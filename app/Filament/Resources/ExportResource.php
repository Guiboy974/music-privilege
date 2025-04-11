<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportResource\Pages;
use App\Filament\Resources\ExportResource\RelationManagers;
use App\Models\Export;
use App\Models\Marketplace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                    ->afterStateUpdated(function ($state, $livewire) {
                        // Associer le marketplace sélectionné à un modèle spécifique
                        $livewire->marketplaceModel = match ($state) {
                            'Amazon' => new \App\Models\ExportAmazon(),
                           /* 'Cdiscount' => new \App\Models\ExportCdiscount(), */
                            default => new \App\Models\Export(), // Modèle par défaut
                        };
                    }),
                Forms\Components\TextInput::make('name_export')
                    ->required(),
                Repeater::make('attributs')
                    ->columns(3)
                    ->schema([
                        Select::make('attribut')
                            ->options(collect((new Export())->getFillable())
                                ->reject(fn ($field) => in_array($field, ['name_marketplace', 'name_export']))
                                ->mapWithKeys(fn ($field) => [$field => ucfirst(str_replace('_', ' ', $field))])->toArray(),
                            )
                            ->live()
                            ->afterStateUpdated(function (callable $set, callable $get, $state, $livewire) {
                                $marketplaceModel = $livewire->marketplaceModel ?? null; // livewire->data['marketplaceModel'];
                
                                if ($marketplaceModel) {
                                    // Appliquer les règles spécifiques du modèle
                                    $set('entete', $marketplaceModel->modifyFieldContent('entete', $state));
                                } else {
                                    // Par défaut, synchroniser directement
                                    $set('entete', $state);
                                }
                            })
                            ->columnSpan(1),
                        TextInput::make('entete')
                            ->label('En tête')
                            ->columnSpan(1),
                        TextInput::make('valeur par defaut')
                        ->columnSpan(1),
                        ])
                        ->defaultItems(3)
                    ->columnSpanFull()
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('entete')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie_ids')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('short_description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('product_online')
                    ->boolean(),
                Tables\Columns\TextColumn::make('tax_class_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('visibility')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('special_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('special_price_to_date')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('url_key')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('base_image'),
                Tables\Columns\TextColumn::make('qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('out_of_stock_qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_cart_qty')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_in_stock')
                    ->boolean(),
                Tables\Columns\TextColumn::make('manage_stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('additional_image'),
                Tables\Columns\TextColumn::make('available')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code_famille')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cost')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ean')
                    ->searchable(),
                Tables\Columns\TextColumn::make('enattente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('encommande')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('garantie')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_solde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('manufacturer')
                    ->searchable(),
                Tables\Columns\IconColumn::make('occasion')
                    ->boolean(),
                Tables\Columns\TextColumn::make('prix_public')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('real_sku')
                    ->searchable(),
                Tables\Columns\TextColumn::make('plus_produit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('eco')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('caracteristique')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instruments')
                    ->searchable(),
                Tables\Columns\TextColumn::make('avis_profdeux')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ean_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ecotaxe')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('frequence')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
