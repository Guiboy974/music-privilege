<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Export extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_marketplace',
        'name_export',
        'name',
        'sku',
        'categorie',
        'categorie_ids',
        'description',
        'short_description',
        'weight',
        'product_online',
        'tax_class_name',
        'visibility',
        'price',
        'special_price',
        'special_price_to_date',
        'url_key',
        'base_image',
        'qty',
        'out_of_stock_qty',
        'max_cart_qty',
        'is_in_stock',
        'manage_stock',
        'additional_image',
	    'availability',
        'status',
        'code_famille',
        'cost',
        'ean',
        'enattente',
        'encommande',
        'garantie',
        'is_solde',
        'manufacturer',
        'occasion',
        'prix_public',
        'real_sku',
        'plus_produit',
        'eco',
        'caracteristique',
        'instruments',
        'avis_profdeux',
        'ean_code',
        'ecotaxe',
        'frequence',
        'is_active',
	    'attributs',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_online' => 'boolean',
        'price' => 'decimal',
        'special_price' => 'decimal',
        'special_price_to_date' => 'decimal',
        'is_in_stock' => 'boolean',
        'cost' => 'decimal',
        'occasion' => 'boolean',
        'prix_public' => 'decimal',
        'eco' => 'decimal',
        'ecotaxe' => 'decimal',
        'is_active' => 'boolean',
        'attributs' => 'array',
    ];

    public function marketplaces(): HasMany
    {
        return $this->hasMany(Marketplace::class);
    }
}
