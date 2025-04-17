<?php

namespace App\Services;

use App\Models\Product; // Assurez-vous que cette table locale est correctement configurée.
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JustBetter\MagentoClient\Query\SearchCriteria;
use JustBetter\MagentoClient\Client\Magento;

class MagentoProductService
{
    protected Magento $magento;

    public function __construct(Magento $magento)
    {
        // Configurer les headers ou autres options si nécessaire
        $magento->intercept(function (\Illuminate\Http\Client\PendingRequest $request) {
            $request->withHeaders([
                'User-Agent' => 'MagentoClient/1.0',
                'Accept' => 'application/json',
            ]);
        });

        $this->magento = $magento;
    }

    /**
     * Synchronise les produits du catalogue Magento vers la base locale.
     */
    public function syncProducts(): void
    {
        // Construire les critères de recherche pour les produits actifs
        $searchCriteria = SearchCriteria::make()
            ->where('status', '1')                 // Produits actifs
	        ->where('visibility', 'neq', '1') // Produits visibles
            //->where('sku', 'eq', 'AMP00AC-ACUSAC098')
            ->orderBy('created_at', 'desc')
            ->paginate(1, 100)
            ->get();


        try {
            // Appel à l'API pour récupérer les produits
            $response = $this->magento->get('products', $searchCriteria);
           
            // Gestion des erreurs d'API
            if ($response->failed()) {
                Log::error('Magento API Error for Products', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception('Magento request failed with status ' . $response->status());
            }

            Log::info('Magento Products Response', ['items' => count($response['items'] ?? [])]);

            // Parcourir et enregistrer les produits
            foreach ($response['items'] as $productData) {
                DB::transaction(function () use ($productData) {
                    // Assurez-vous d'avoir un modèle Product ou équivalent configuré.
                    $product = Product::updateOrCreate(
                        ['sku' => $productData['sku']], // Identifier le produit par son SKU
                        $this->mapProductData($productData)
                    );
                    dd($productData);
                    Log::info('Produit synchronisé', ['sku' => $product->sku]);
                });
            }
        } catch (\Exception $exception) {
            Log::error('Erreur lors de la synchronisation des produits Magento', [
                'message' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    /**
     * Mapper les données du produit Magento avec votre modèle local.
     */
    public function mapProductData(array $productData): array
    {
        $extensionAttributes = $productData['extension_attributes'] ?? [];

        return [
            'sku' => $productData['sku'],
            'name' => $productData['name'],
            'price' => $productData['price'],
            'status' => $productData['status'], // Actif ou inactif
            'visibility' => $productData['visibility'], // Visibilité dans le catalogue
            'created_at' => $productData['created_at'],
            'updated_at' => $productData['updated_at'],
            // Champs personnalisés depuis les extension_attributes
            'special_price' => $extensionAttributes['special_price'] ?? null,
            'description' => $productData['custom_attributes']['description'] ?? null,
            'short_description' => $productData['custom_attributes']['short_description'] ?? null,
            'weight' => $productData['weight'] ?? null,
        ];
    }
}
