<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportResource\Pages;
use App\Filament\Resources\ExportResource\RelationManagers;
use App\Models\Export;
use App\Models\Marketplace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

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
                        // Stocker la valeur dans une propriété de session ou composant
                        $livewire->marketplace = $state;
                    }),
                Forms\Components\TextInput::make('name_export')
                    ->required(),
                Repeater::make('attributs')
                    ->schema([
                        Select::make('attribut')
                            ->options(collect((new Export())->getFillable())
                                ->reject(fn ($field) => in_array($field, ['name_marketplace', 'name_export']))
                                ->mapWithKeys(fn ($field) => [$field => ucfirst(str_replace('_', ' ', $field))])->toArray(),
                            )
                            ->live()
                            ->afterStateUpdated(function (callable $set, callable $get, $state, $livewire) {
                                $marketplaceName = $livewire->data['name_marketplace'] ?? '';

                                // Mettre à jour le TextInput 'En tête'
                                $set('En tête', $state);

                            }),
                        TextInput::make('En tête')
                            ->disabled(), // Assurez-vous que le champ est hydraté pour qu'il puisse être mis à jour
                        TextInput::make('valeur par defaut')
                    ])
                    ->columnSpanFull()
                ->columns(2)
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
                Tables\Columns\TextColumn::make('name_product')
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
