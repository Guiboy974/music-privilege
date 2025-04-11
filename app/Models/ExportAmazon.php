<?php

namespace App\Models;

use App\Models\Export;

class ExportAmazon extends Export
{
    public function getRules(): array
    {
        return [
            'sku' => [
                'type' => 'string',
                'max_length' => 40,
            ],
            'price' => [
                'type' => 'float',
                'min_value' => 0,
            ],
            'name' => [
                'type' => 'string',
                'max_length' => 200,
            ],
            'description' => [
                'type' => 'string',
                'max_length' => 2000,
            ],
            'short_description' => [
                'type' => 'string',
                'max_length' => 500,
            ],
        ];
    }

    public function modifyFieldContent(string $field, $value)
    {
        // Apply specific transformations for Amazon
        if ($field === 'sku') {
            return strtoupper($value); // Convert to uppercase
        }
        if ($field === 'name') {
            return ucfirst($value); // Capitalize the first letter
        }
        
        return $value;
    }
}