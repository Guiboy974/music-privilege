<?php

namespace App\Models;

use App\Services\MagentoProductService;
use JustBetter\MagentoClient\Client\Magento;

class DefaultMarketplaceModel extends AbstractMarketplaceModel {

    protected ?MagentoProductService $magentoProductService;
    protected ?Magento $magento = null;

    //TODO corriger
    public function __construct(MagentoProductService $magentoProductService = null)
    {
        $this->magentoProductService = $magentoProductService;
        if ($magentoProductService) {
            $this->magento = $magentoProductService->getMagento();
        }
        }

    /**
     * Transforme la valeur selon la clé (description, etc.)
     */
	public function transformValue($attributeKey, $value) {

        switch ($attributeKey)
        {
            case 'description':
                return $this->transformDescription($value);
            case 'categories':
                return $this->refactorCategories($value);
            case 'delivery_cost':
                return $this->calculateDeliveryCost($value);
            default:
                return parent::transformValue($attributeKey, $value);
        }
    }

    /**
     * Nettoie la description : supprime les balises HTML, entités, et espaces superflus.
     */
    protected function transformDescription(?string $value): string
    {
        $value = $value ?? '';
        // Décoder les entités HTML
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Supprimer les balises HTML
        $value = strip_tags($value);

        // Réduire les espaces multiples à un seul espace
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    }

    protected function refactorCategories($value) {
        // Préfixe initial
        $categoriesInit = 'Instruments';

        // Si `$value` est déjà une chaîne, transformez-la en tableau
        $categoriesArray = is_string($value) ? explode(', ', $value) : (array) $value;

        // Vérifiez si le tableau contient des catégories, puis ajoutez le préfixe uniquement à la première.
        if (!empty($categoriesArray)) {
            return $categoriesInit . ' > ' . implode(' > ', $categoriesArray);
        }

        // Si `$value` est vide, retourner uniquement le préfixe
        return $categoriesInit;

    }


    /**
     * Calcule le coût de livraison basé sur le prix depuis Magento.
     */
    protected function calculateDeliveryCost(?float $price): string
    {
        // Appelez Magento pour récupérer les informations sur le produit.
        $originalPrice = $this->magentoProductService->getProductPrice('product_sku'); // Remplacez 'product_sku' avec la clé SKU ou ID approprié.

        // Utilisez le prix original (ou de fallback au $price fourni)
        $priceFloat = $originalPrice ?? $price;

        // Calculez le coût de livraison
        return $priceFloat < 35 ? '6.90 EUR' : '0';
    }

}
