<?php

return [
    'rules' => [
        'title' => 'required|string|max:100',
        'price' => 'required|numeric',
        // Ajoutez d'autres règles spécifiques à Amazon
    ],
    'transformations' => [
        'title' => function($value) {
            // Transformation spécifique pour le titre sur Amazon
            return ucwords($value);
        },
        'price' => function($value) {
            // Transformation spécifique pour le prix sur Amazon
            return number_format($value, 2);
        },
        // Ajoutez d'autres transformations spécifiques
    ],
];
