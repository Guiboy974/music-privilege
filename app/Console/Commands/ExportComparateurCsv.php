<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Export;
use Illuminate\Support\Facades\Storage;
use App\Services\MagentoProductService;
use Illuminate\Support\Str;
use League\Csv\Writer;
use App\Models\Marketplace;
use Log;

class ExportComparateurCsv extends Command
{
    protected $signature = 'comparateur:export-csv';
    protected $description = 'Génère les fichiers CSV pour chaque export configuré, et les envoie aux comparateurs.';

    public function handle()
    {
        $exports = Export::all();
        $magentoProductService = app(MagentoProductService::class);
        $magentoProducts = $magentoProductService->syncProducts();

        foreach ($exports as $export) {
            $marketplace = Marketplace::where('name', $export->name_marketplace)->first();
            if (!$marketplace) {
                $this->error("Marketplace introuvable: {$export->name_marketplace}");
                continue;
            }

            $modelClass = 'App\\Models\\' . $marketplace->name;
            $model = class_exists($modelClass) ? new $modelClass : new \App\Models\DefaultMarketplaceModel();

            $separator = $marketplace->separator ?? ',';
            $delimiter = $marketplace->delimiter ?? '"';

            $csv = Writer::createFromString('');
            $csv->setDelimiter($separator);
            $csv->setEnclosure($delimiter);

            $headers = collect($export->attributs)
                ->map(fn($item) => $item['entete'] ?? $item['attribut'])
                ->toArray();
            $csv->insertOne($headers);

            foreach ($magentoProducts as $product) {
                $row = collect($export->attributs)->map(function ($attr) use ($product, $model) {
                    $key = $attr['attribut'];
                    $default = $attr['Valeur par défaut'] ?? null;

                    $value = $product[$key] ??
                        $product['extension_attributes'][$key] ??
                        collect($product['custom_attributes'])->firstWhere('attribute_code', $key)['value'] ??
                        $default;

                    return $model->transformValue($key, $value);
                })->toArray();

                $csv->insertOne($row);
            }

            $slug = Str::slug($export->name_export, '_');
            $fileName = $slug . '.csv';
            $filePath = 'public/' . $fileName;
            Storage::put($filePath, $csv->toString());

            $this->info("Fichier exporté : $filePath");

            // 👉 Ici, tu peux appeler une méthode pour envoyer le fichier au comparateur
            $this->sendToComparateur($marketplace, $filePath);
        }

        $this->info('Tous les fichiers ont été générés.');
    }

    protected function sendToComparateur($marketplace, $filePath)
    {
        $host = $marketplace->ftp_host;
        $user = $marketplace->ftp_user;
        $pass = $marketplace->ftp_pass;

        $localFile = Storage::path($filePath);

        $connection = ftp_connect($host);
        $login = ftp_login($connection, $user, $pass);

        if ($connection && $login) {
            ftp_put($connection, basename($filePath), $localFile, FTP_BINARY);
            ftp_close($connection);
            $this->info("Fichier envoyé à {$marketplace->name}");
        } else {
            $this->error("Échec de la connexion FTP à {$marketplace->name}");
        }
    }

}
