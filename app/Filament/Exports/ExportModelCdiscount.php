<?php
namespace App\Filament\Exports;

class ExportModelCdiscount
{
public function transform(array $product, array $attributes): array
{
return collect($attributes)->map(function ($item) use ($product) {
$attribute = $item['attribut'];
$value = $product[$attribute] ?? '';

// Transformation spécifique pour Cdiscount
if ($attribute === 'price') {
$value .= ' €'; // Ajouter l'unité de devise
}

return $value;
})->toArray();
}
}
