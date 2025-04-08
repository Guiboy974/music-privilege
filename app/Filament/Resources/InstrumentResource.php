<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstrumentResource\Pages;
use App\Filament\Resources\InstrumentResource\RelationManagers;
use App\Models\Instrument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstrumentResource extends Resource
{
    protected static ?string $model = Instrument::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->required(),
                Forms\Components\TextInput::make('categorie')
                    ->required(),
                Forms\Components\TextInput::make('categorie_ids')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('description'),
                Forms\Components\TextInput::make('short_description'),
                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('product_online')
                    ->required(),
                Forms\Components\TextInput::make('tax_class_name')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('visibility'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('special_price')
                    ->numeric(),
                Forms\Components\TextInput::make('special_price_to_date')
                    ->numeric(),
                Forms\Components\TextInput::make('url_key')
                    ->required(),
                Forms\Components\FileUpload::make('base_image')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('qty')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('out_of_stock_qty')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('max_cart_qty')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_in_stock')
                    ->required(),
                Forms\Components\TextInput::make('manage_stock')
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('additional_image')
                    ->image(),
                Forms\Components\TextInput::make('available'),
                Forms\Components\TextInput::make('code_famille')
                    ->required(),
                Forms\Components\TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('ean'),
                Forms\Components\TextInput::make('enattente'),
                Forms\Components\TextInput::make('encommande')
                    ->numeric(),
                Forms\Components\TextInput::make('garantie')
                    ->numeric(),
                Forms\Components\TextInput::make('is_solde'),
                Forms\Components\TextInput::make('manufacturer')
                    ->required(),
                Forms\Components\Toggle::make('occasion')
                    ->required(),
                Forms\Components\TextInput::make('prix_public')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('real_sku')
                    ->required(),
                Forms\Components\TextInput::make('plus_produit'),
                Forms\Components\TextInput::make('eco')
                    ->numeric(),
                Forms\Components\TextInput::make('caracteristique'),
                Forms\Components\TextInput::make('instruments'),
                Forms\Components\TextInput::make('avis_profdeux'),
                Forms\Components\TextInput::make('ean_code'),
                Forms\Components\TextInput::make('ecotaxe')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie_ids')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
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
            'index' => Pages\ListInstruments::route('/'),
            'create' => Pages\CreateInstrument::route('/create'),
            'edit' => Pages\EditInstrument::route('/{record}/edit'),
        ];
    }
}
