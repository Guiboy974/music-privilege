<?php

namespace App\Models;

class Idealo extends DefaultMarketplaceModel
{

    /** transforme des valeurs dans les champs
     * @param $attributeKey
     * @param $value
     * @return mixed|string
     */
    public function transformValue($attributeKey, $value)
    {
        switch ($attributeKey) {

            // TODO a définir spécifiquement pour chaque attribut avec la public fonction qui correspond
            case 'name':
                return $this->formatName($value);
            case 'description':
                return $this->formatDescription($value);
            case 'price':
                return $this->formatPrice($value);
            case 'url_key':
                return $this->formatUrl($value);
            case 'base_image':
                return $this->linkImage($value);
            case 'is_in_stock':
                return $this->availableValue($value);
            default:
                return parent::transformValue($attributeKey, $value);
        }
    }

    protected function formatName($value): string {
        if (strlen($value) >= 100) {
            $substring = substr($value, 0, 100);
            $lastDotPosition = strrpos($substring, '.');
            if ($lastDotPosition !== false) {
                return substr($substring, 0, $lastDotPosition + 1);
            }
            return substr($value, 0, 100);
        }
        return $value;
    }

    /** format le prix a mettre dans le champ
     * @param $value
     * @return string
     */
    protected function formatPrice($value): string
    {
        return number_format((float) $value, 2, '.', '') . ' EUR';
    }

    //TODO description max caractere 2000
    protected function formatDescription($value): string {
        return $value;
    }

    //TODO valeur en https ou http
    protected function formatUrl($value): string {
        return $value;
    }

    //TODO URL directe vers image produit
    protected function linkImage($value): string {
        return $value;
    }

    //TODO valeur attendue in stock, ot of stock, preorder
    protected function availableValue($value): string {
        return $value;
    }
}
