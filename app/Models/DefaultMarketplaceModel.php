<?php

namespace App\Models;

use App\Services\MagentoProductService;
use Illuminate\Support\Facades\Log;
use JustBetter\MagentoClient\Client\Magento;

class DefaultMarketplaceModel extends AbstractMarketplaceModel {

    // Seuil et frais
    private const FREE_SHIPPING_THRESHOLD = 35.0;
    private const DELIVERY_FEE = 6.90;

    /** @var string|null Stocke le SKU courant dès qu’il est rencontré */
    protected ?string $currentSku = null;

    /** Setter public pour fixer le SKU avant chaque boucle produit */
    public function setCurrentSku(string $sku): self
    {
        $this->currentSku = $sku;
        return $this;
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
                $price = is_numeric($value) ? (float) $value : 0.0;

                // Si pas de SKU, on fait un fallback tout simple
                if (empty($this->currentSku))
                {
                    Log::warning('DefaultMarketplaceModel: delivery_cost sans SKU',
                        ['price' => $price]
                    );
                    $fee = $price < self::FREE_SHIPPING_THRESHOLD
                        ? self::DELIVERY_FEE
                        : 0.0;
                    return number_format($fee, 2, '.', '') . ' EUR';
                }
                // Sinon, lecture du cache (aucun appel Magento ici)
                $cached = app(MagentoProductService::class)
                    ->getCachedPrice($this->currentSku);

                $effective = $cached ?? $price;
                $fee = $effective < self::FREE_SHIPPING_THRESHOLD
                    ? self::DELIVERY_FEE
                    : 0.0;
                return number_format($fee, 2, '.', '') . ' EUR';

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

}
