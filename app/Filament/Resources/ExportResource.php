<?php
namespace App\Filament\Resources;

use App\Filament\Exports\ExportModelCdiscount;
use App\Filament\Exports\ProductExporter;
use App\Filament\Resources\ExportResource\Pages;
use App\Filament\Resources\ExportResource\Pages\CreateExport;
use App\Filament\Resources\ExportResource\RelationManagers;
use App\Models\Export;
use App\Models\Marketplace;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\ExportAttributs;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\MagentoProductService;
use Filament\Tables\Actions\ExportAction;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Support\Str;

class ExportResource extends Resource
{
    protected static ?string $model = Export::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name_marketplace')
                    ->label('Comparateur/Marketplace')
                    ->options(Marketplace::all()->pluck('name', 'name'))
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('name_export')
                    ->required()
					->afterStateUpdated(function (callable $set, $state) {
						$set('slug', Str::slug($state, '_'));
					}),
                Repeater::make('attributs')
                    ->columns(3)
                    ->schema([
                        Select::make('attribut')
                            ->options(collect((new Export())->getFillable())
                                ->reject(fn($field) => in_array($field, ['name_marketplace', 'name_export']))
                                ->mapWithKeys(fn($field) => [$field => ucfirst(str_replace('_', ' ', $field))])->toArray(),
                            )
                            ->live()
                            ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                // Par défaut, synchroniser directement
                                $set('entete', $state);

                            })
                            ->columnSpan(1),
                        TextInput::make('entete')
                            ->label('En tête')
                            ->columnSpan(1),
                        TextInput::make('Valeur par défaut')
                            ->columnSpan(1),
                    ])
                    ->defaultItems(fn (?Export $record) => $record ? 0 : 3)
                    ->columnSpanFull(),

        Forms\Components\Actions::make([
            Forms\Components\Actions\Action::make('export')
                        ->label('Exporter en CSV')
                        ->action(function ($state, $livewire) {
	                        // Instanciation du modèle marketplace dès le début :
                            $magentoProductService = app(MagentoProductService::class);

                            $marketplaceName = $state['name_marketplace'];
	                        $modelClass = 'App\\Models\\' . $marketplaceName;
	                        if (class_exists($modelClass)) {
		                        $model = new $modelClass($magentoProductService);
	                        } else {
		                        $model = new \App\Models\DefaultMarketplaceModel($magentoProductService);
	                        }

                            // Récupérer les données Magento
                            $magentoProductService = app(MagentoProductService::class);
                            $magentoProducts = $magentoProductService->syncProducts();

	                        // Obtenir le Marketplace sélectionné
	                        $marketplaceName = $state['name_marketplace'];
	                        $marketplace = Marketplace::where('name', $marketplaceName)->first();

	                        if (!$marketplace) {
		                        Notification::make()
			                        ->title('Erreur')
			                        ->body('Le Marketplace sélectionné est introuvable.')
			                        ->danger()
			                        ->send();
		                        return;
	                        }

	                        // Récupérer le séparateur et le délimiteur
	                        $separator = !empty($marketplace->separator) ? $marketplace->separator : ',';
	                        $delimiter = !empty($marketplace->delimiter) ? $marketplace->delimiter : '"';

	                        // Initialiser le fichier CSV
                            $csv = Writer::createFromString('');
	                        $csv->setDelimiter($separator);
	                        $csv->setEnclosure($delimiter);

	                        // Construire les en-têtes dynamiques à partir du formulaire
                            $headers = collect($state['attributs'])
                                ->map(fn($item) => $item['entete'] ?? $item['attribut'])
                                ->toArray();
                            $csv->insertOne($headers);

	                        //Parcourir et traiter les produits
	                        foreach ($magentoProducts as $product) {
		                        $transformedData = collect($state['attributs'])->map(function ($attribute) use ($product, $model) {
			                        $attributeKey = $attribute['attribut'];
			                        $defaultValue = $attribute['Valeur par défaut'] ?? null;
			                        $value = null;

			                        if (isset($product[$attributeKey])) {
				                        // Si la clé est directement dans le tableau principal
				                        $value = $product[$attributeKey];
			                        } elseif (isset($product['extension_attributes'][$attributeKey])) {
				                        // Si la clé se trouve dans 'extension_attributes'
				                        $value = $product['extension_attributes'][$attributeKey];
			                        } elseif (isset($product['custom_attributes'])) {
				                        // Rechercher dans 'custom_attributes' via 'attribute_code'
				                        $customAttribute = collect($product['custom_attributes'])
					                        ->firstWhere('attribute_code', $attributeKey);
				                        Log::warning('Attribut manquant pour un produit', ['attribut' => $attributeKey, 'sku' => $product['sku']]);

				                        $value = $customAttribute['value'] ?? null;
			                        }

			                        // Transformation selon le modèle Marketplace (si nécessaire)
			                        if (is_object($model)) {
				                        $value = $model->transformValue($attributeKey, $value);
			                        }
			                        return $value ?? $defaultValue; // Valeur ou valeur par défaut
		                        })->toArray();

		                        $csv->insertOne($transformedData); // Insérer la ligne dans le CSV
	                        }

	                        // Créer et sauvegarder le fichier
	                        $slug = Str::slug($state['name_export'], '_');
	                        $fileName = $slug . '.csv';
							$filePath = 'public/' . $fileName;
                            Storage::put($filePath, $csv->toString());

	                        // Générer une URL de téléchargement temporaire
	                        $downloadUrl = Storage::url($filePath);

	                        // Notifier l'utilisateur du succès
                            Notification::make()
								->title("L'export a été généré avec succès.")
                                ->success()
                                ->send();

	                        // Déclencher le téléchargement direct (pour les disques locaux)
	                        return response()->download(Storage::path($filePath),
	                            $fileName, [
			                        'Content-Type' => 'text/csv',
		                        ])
		                        ->deleteFileAfterSend(false);
                        })
                ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_marketplace')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_export')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Télécharger') // Libellé du bouton
                    ->icon('heroicon-o-arrow-down-tray') // Icône pour le téléchargement

                    ->url(function ($record) {
                        // Générer le chemin du fichier
		                $slug = \Illuminate\Support\Str::slug($record->name_export, '_');
                        $filePath = 'public/' . $slug . '.csv';

                        // Vérifier si le fichier existe
                        if (\Illuminate\Support\Facades\Storage::exists($filePath)) {
                            $url = Storage::url($filePath);
							return $url;// Retourner l'URL publique du fichier
                        }
                        return null; // Retourner null si le fichier n'existe pas
                    })
                    ->color('success'),
	            Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExports::route('/'),
            'create' => Pages\CreateExport::route('/create'),
            'edit' => Pages\EditExport::route('/{record}/edit'),
        ];
    }


}
