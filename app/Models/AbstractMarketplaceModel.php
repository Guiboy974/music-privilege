<?php

namespace App\Models;

Abstract class AbstractMarketplaceModel
{
    /**
     * Transforme la valeur d’un attribut selon la logique du comparateur/marketplace.
     */
	public function transformValue($attributeKey, $value) {

		return $value;
	}
}
