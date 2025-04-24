<?php

namespace App\Models;

class Idealo extends DefaultMarketplaceModel
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
            case 'description':
                return $this->formatDescription($value);
            case 'price':
                return $this->formatPrice($value);
            case 'url_key':
                return $this->formatUrl($value);
            case 'base_image':
                return $this->linkImage($value);
            case 'weight':
                return $this->formatWeight($value);
            case 'categories':
                return $this->refactorCategories($value);
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

    /** limite a 2000 caractere max, en fonction du dernier point trouver
     * @param $value
     * @return string
     */
    protected function formatDescription($value): string {
        $limite = 2000;

        if (strlen($value) <= $limite) {
            return $value;
        }

        $substring = substr($value, 0, $limite);
        if (str_ends_with($substring, '.')) {
            return $substring;
        }

        $lastDotPosition = strrpos($substring, '.');
        if ($lastDotPosition !== false) {
            return substr($substring, 0, $lastDotPosition + 1);
        }

        return $substring;
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

    /**
     * @param $value
     */
    protected function formatWeight($value) {
        if ($value === null) {
            return "";
        }
        return number_format((float) $value, 2, '.', '');
    }

    protected function refactorCategories($value) {

    }
}
