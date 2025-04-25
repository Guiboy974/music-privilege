<?php

namespace App\Models;

class DefaultMarketplaceModel extends AbstractMarketplaceModel {

    /**
     * Transforme la valeur selon la clé (description, etc.)
     */
	public function transformValue($attributeKey, $value) {

        switch ($attributeKey) {
            case 'description':
                return $this->transformDescription($value);

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
}
