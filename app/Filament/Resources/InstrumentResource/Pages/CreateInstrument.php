<?php

namespace App\Filament\Resources\InstrumentResource\Pages;

use App\Filament\Resources\InstrumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInstrument extends CreateRecord
{
    protected static string $resource = InstrumentResource::class;

//    public function getProductSku() {
//        $client = app(\JustBetter\MagentoClient\Client\Magento::class);
//        $client->get('products/sku');
//        if ($client->isSuccess()) {
//            return $client->getResponse();
//        }
//    }

}
