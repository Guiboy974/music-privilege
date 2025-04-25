<?php

namespace App\Models;

class LeGuide extends Idealo
{

    /** transforme des valeurs dans les champs
     * @param $attributeKey
     * @param $value
     * @return mixed|string
     */
    public function transformValue($attributeKey, $value)
    {
        switch ($attributeKey) {
            case 'price':
                return $this->formatPrice($value);
            case 'occasion':
                return $this->formatCondition($value);
            default:
                return parent::transformValue($attributeKey, $value);
        }
    }

    /** format le prix a mettre dans le champ
     * @param $value
     * @return string
     */
    protected function formatPrice($value): string
    {
        return number_format((float) $value, 2, '.', '');
    }

    //TODO valeur attendue refurbished?
    protected function formatCondition($value): string
    {
        if ($value == '0')
        {
            return 'new';
        } elseif ($value == '1')
        {
            return 'used';
        } else
        {
            return '';
        }
    }

}
