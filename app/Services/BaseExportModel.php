<?php
namespace App\Services;


use App\Filament\Exports\ProductExporter;

class BaseExportModel
{
public function handleExport(array $magentoProducts, array $repeaterState, ProductExporter $exportModel): array
{
$rows = [];
foreach ($magentoProducts as $product) {
$rows[] = $exportModel->transform($product, $repeaterState);
}
return $rows;
}
}
