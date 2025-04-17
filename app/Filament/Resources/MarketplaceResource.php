<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarketplaceResource\Pages;
use App\Filament\Resources\MarketplaceResource\RelationManagers;
use App\Models\Marketplace;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MarketplaceResource extends Resource
{
    protected static ?string $model = Marketplace::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('description'),
                Forms\Components\TextInput::make('url'),
                Forms\Components\TextInput::make('logo'),
                Forms\Components\Toggle::make('is_active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('logo')
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
            'index' => Pages\ListMarketplaces::route('/'),
            'create' => Pages\CreateMarketplace::route('/create'),
            'edit' => Pages\EditMarketplace::route('/{record}/edit'),
        ];
    }

    /**
     * Renvoie les options disponibles pour les séparateurs de CSV.
     *
     * @return array
     */
    protected static function getSeparators(): array
    {
        return [
            ';' => 'Point-virgule ( ; )',
            ',' => 'Virgule ( , )',
            '\t' => 'Tabulation (Tab)',
            '|' => 'Barre verticale ( | )',
            ' ' => 'Espace (blanc)',
        ];
    }

    /**
     * Renvoie les options disponibles pour les délimiteurs de CSV.
     *
     * @return array
     */
    protected static function getDelimiters(): array
    {
        return [
            '"' => 'Double guillemet ( " )',
            "'" => "Simple guillemet ( ' )",
            ' ' => 'Aucun (espace)',
            '|' => 'Barre verticale ( | )',
        ];
    }
}
