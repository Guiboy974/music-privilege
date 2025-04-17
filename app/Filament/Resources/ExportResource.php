<?php
namespace App\Filament\Resources;

use App\Filament\Exports\ExportModelCdiscount;
use App\Filament\Exports\ProductExporter;
use App\Filament\Resources\ExportResource\Pages;
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
use Maatwebsite\Excel\Facades\Excel;
use App\Services\MagentoProductService;
use Filament\Tables\Actions\ExportAction;

//use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletingScope;
// use App\Filament\Exports\ProductExporter;


class ExportResource extends Resource
{

    protected static ?string $model = Export::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name_marketplace')
                    ->options(Marketplace::all()->pluck('name', 'name'))
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $livewire
                    ) {
                        // Associer le modèle en fonction du marketplace sélectionné
                        $livewire->marketplaceModel = $state;
                    }),
                Forms\Components\TextInput::make('name_export')
                    ->required(),
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
                                $magentoProductService = app(MagentoProductService::class);

//                                // Obtenez des exemples de produits (ou le format de l'attribut Magento dynamique)
//                                $productAttributes = $magentoProductService->mapProductData();
//                                $exampleValue = $productAttributes[$state] ?? 'Valeur par défaut'; // Exemple valeur fictive

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
                    ->defaultItems(3)
                    ->columnSpanFull(),

        Forms\Components\Actions::make([
            Forms\Components\Actions\Action::make('export')
                        ->label('Exporter en CSV')
                        ->action(function ($state, $livewire) {
                            $magentoProductService = app(MagentoProductService::class);

                            // Récupérer les données Magento
                            $magentoProducts = $magentoProductService->syncProducts();

                            // Initialiser le fichier CSV
                            $csv = Writer::createFromString('');

                            // Construire les en-têtes dynamiques à partir du formulaire
                            $headers = collect($state['attributs'])
                                ->map(fn($item) => $item['entete'] ?? $item['attribut'])
                                ->toArray();
                            $csv->insertOne($headers);

                            // Transformer et insérer les lignes dans le CSV
            foreach ($magentoProducts as $product) {
                $transformedData = collect($state['attributs'])->map(function ($attribute) use ($product, $livewire) {
                    $attributeKey = $attribute['attribut'];
                    $value = $product[$attributeKey] ?? null;

                    // Appeler le modèle spécifique au marketplace pour transformer les valeurs
                    return $livewire->marketplaceModel->transformValue($attributeKey, $value);
                })->toArray();

                $csv->insertOne($transformedData);
            }

                            // Créer et sauvegarder le fichier
                            $fileName = $state['name_export'] . '.csv';
                            $filePath = "exports/$fileName";
                            Storage::put($filePath, $csv->toString());

                            // Notifier l'utilisateur du succès
                            $livewire->notify(
                                'success',
                                "L'export a été généré avec succès. [Télécharger](" . asset('storage/' . $filePath) . ")"
                            );
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                        $filePath = 'storage/exports/' . $record->name_export . '.csv';

                        // Vérifier si le fichier existe
                        if (\Illuminate\Support\Facades\Storage::exists('exports/' . $record->name_export . '.csv')) {
                            return asset($filePath); // Retourner l'URL publique du fichier
                        }
                        return null; // Retourner null si le fichier n'existe pas
                    })
                    ->color('success'),

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
