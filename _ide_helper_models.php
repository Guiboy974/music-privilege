<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name_marketplace
 * @property string $name_export
 * @property string|null $name_product
 * @property string $sku
 * @property string|null $categorie
 * @property int|null $categorie_ids
 * @property string|null $description
 * @property string|null $short_description
 * @property int|null $weight
 * @property bool|null $product_online
 * @property int|null $tax_class_name
 * @property string|null $visibility
 * @property numeric|null $price
 * @property numeric|null $special_price
 * @property numeric|null $special_price_to_date
 * @property string|null $url_key
 * @property string|null $base_image
 * @property int|null $qty
 * @property int|null $out_of_stock_qty
 * @property int|null $max_cart_qty
 * @property bool|null $is_in_stock
 * @property int|null $manage_stock
 * @property string|null $additional_image
 * @property string|null $available
 * @property string|null $code_famille
 * @property numeric|null $cost
 * @property string|null $ean
 * @property string|null $enattente
 * @property int|null $encommande
 * @property int|null $garantie
 * @property string|null $is_solde
 * @property string|null $manufacturer
 * @property bool $occasion
 * @property numeric|null $prix_public
 * @property string|null $real_sku
 * @property string|null $plus_produit
 * @property numeric|null $eco
 * @property string|null $caracteristique
 * @property string|null $instruments
 * @property string|null $avis_profdeux
 * @property string|null $ean_code
 * @property numeric|null $ecotaxe
 * @property string|null $frequence
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Marketplace> $marketplaces
 * @property-read int|null $marketplaces_count
 * @method static \Database\Factories\ExportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereAdditionalImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereAvisProfdeux($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereBaseImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereCaracteristique($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereCategorieIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereCodeFamille($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereEan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereEanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereEco($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereEcotaxe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereEnattente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereEncommande($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereFrequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereGarantie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereInstruments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereIsInStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereIsSolde($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereManageStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereMaxCartQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereNameExport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereNameMarketplace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereNameProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereOccasion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereOutOfStockQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export wherePlusProduit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export wherePrixPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereProductOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereRealSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereSpecialPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereSpecialPriceToDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereTaxClassName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereUrlKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Export whereWeight($value)
 */
	class Export extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $url
 * @property string|null $logo
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\MarketplaceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketplace whereUrl($value)
 */
	class Marketplace extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name_product
 * @property string $sku
 * @property string $categorie
 * @property int $categorie_ids
 * @property string|null $description
 * @property string|null $short_description
 * @property int $weight
 * @property bool $product_online
 * @property int $tax_class_name
 * @property string|null $visibility
 * @property numeric $price
 * @property numeric|null $special_price
 * @property numeric|null $special_price_to_date
 * @property string $url_key
 * @property string $base_image
 * @property int $qty
 * @property int $out_of_stock_qty
 * @property int $max_cart_qty
 * @property bool $is_in_stock
 * @property int $manage_stock
 * @property string|null $additional_image
 * @property string|null $available
 * @property string $code_famille
 * @property numeric $cost
 * @property string|null $ean
 * @property string|null $enattente
 * @property int|null $encommande
 * @property int|null $garantie
 * @property string|null $is_solde
 * @property string $manufacturer
 * @property bool $occasion
 * @property numeric $prix_public
 * @property string $real_sku
 * @property string|null $plus_produit
 * @property numeric|null $eco
 * @property string|null $caracteristique
 * @property string|null $instruments
 * @property string|null $avis_profdeux
 * @property string|null $ean_code
 * @property numeric|null $ecotaxe
 * @property string|null $frequence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Export> $exports
 * @property-read int|null $exports_count
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereAdditionalImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereAvisProfdeux($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereBaseImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCaracteristique($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategorieIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCodeFamille($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereEan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereEanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereEco($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereEcotaxe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereEnattente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereEncommande($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereFrequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereGarantie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereInstruments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsInStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsSolde($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereManageStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMaxCartQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereNameProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereOccasion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereOutOfStockQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePlusProduit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrixPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereRealSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSpecialPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSpecialPriceToDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereTaxClassName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUrlKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereWeight($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property bool $is_admin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

