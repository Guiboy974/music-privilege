<?php

namespace App\Models;

class GoogleShopping extends DefaultMarketplaceModel
{
    protected const BASE_URL = 'https://staging.music-privilege.fr/';
    protected const IMAGE_PATH = 'img/600/744/contains/catalog/product';

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
            case 'price':
                return $this->formatPrice($value);
            case 'url_key':
                return $this->formatUrl($value);
            case 'base_image':
                return $this->linkImage($value);
//            case 'availability':
//                return $this->availableValue($value);
            default:
                return parent::transformValue($attributeKey, $value);
        }
    }

    /** limite la chaine de caractere et la fait terminer par le dernier point si plus de 150 caractere
     * @param $value
     * @return string
     */
    protected function formatName($value): string {
        if (strlen($value) >= 150) {
            $substring = substr($value, 0, 150);
            $lastDotPosition = strrpos($substring, '.');
            if ($lastDotPosition !== false) {
                return substr($substring, 0, $lastDotPosition + 1);
            }
            return substr($value, 0, 150);
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

    /**
     * @param string $value
     * @return string
     */
    protected function formatUrl(string $value): string {
        return self::BASE_URL . $value . '.html';
    }

    /**
     * @param string $value
     * @return string
     */
    protected function linkImage(string $value): string {
        return self::BASE_URL . self::IMAGE_PATH . $value;
    }

    //TODO valeur attendue in stock, out of stock, preorder
    protected function availableValue($value): string {
        return $value;
    }
}
