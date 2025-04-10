<?php

namespace App\Filament\Resources\MarketplaceResource\Pages;

use App\Filament\Resources\MarketplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketplace extends EditRecord
{
    protected static string $resource = MarketplaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
