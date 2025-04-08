<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Categorie;
use App\Models\Instrument;

class InstrumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Instrument::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sku' => fake()->word(),
            'categorie' => fake()->word(),
            'categorie_ids' => Categorie::factory(),
            'name' => fake()->name(),
            'description' => fake()->text(),
            'short_description' => fake()->word(),
            'weight' => fake()->numberBetween(-10000, 10000),
            'product_online' => fake()->boolean(),
            'tax_class_name' => fake()->numberBetween(-10000, 10000),
            'visibility' => fake()->word(),
            'price' => fake()->randomFloat(2, 0, 999999.99),
            'special_price' => fake()->randomFloat(2, 0, 999999.99),
            'special_price_to_date' => fake()->randomFloat(2, 0, 999999.99),
            'url_key' => fake()->word(),
            'base_image' => fake()->word(),
            'qty' => fake()->numberBetween(-10000, 10000),
            'out_of_stock_qty' => fake()->numberBetween(-10000, 10000),
            'max_cart_qty' => fake()->numberBetween(-10000, 10000),
            'is_in_stock' => fake()->boolean(),
            'manage_stock' => fake()->numberBetween(-10000, 10000),
            'additional_image' => fake()->word(),
            'available' => fake()->word(),
            'code_famille' => fake()->word(),
            'cost' => fake()->randomFloat(2, 0, 999999.99),
            'ean' => fake()->word(),
            'enattente' => fake()->word(),
            'encommande' => fake()->numberBetween(-10000, 10000),
            'garantie' => fake()->numberBetween(-10000, 10000),
            'is_solde' => fake()->word(),
            'manufacturer' => fake()->word(),
            'occasion' => fake()->boolean(),
            'prix_public' => fake()->randomFloat(2, 0, 999999.99),
            'real_sku' => fake()->word(),
            'plus_produit' => fake()->word(),
            'eco' => fake()->randomFloat(2, 0, 9.99),
            'caracteristique' => fake()->word(),
            'instruments' => fake()->word(),
            'avis_profdeux' => fake()->word(),
            'ean_code' => fake()->word(),
            'ecotaxe' => fake()->randomFloat(2, 0, 9.99),
        ];
    }
}
