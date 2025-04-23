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

            // TODO a définir spécifiquement pour chaque attribut avec la public fonction qui correspond
            case 'occasion':
                return $this->formatCondition($value);
            default:
                return parent::transformValue($attributeKey, $value);
        }
    }

    //TODO valeur attendue new, used, refurbished
    protected function formatCondition($value): string
    {
        if ($value == 'non')
        {
            $value = 'new';
            return $value;
        } else
        {
            $value = 'used';
            return $value;
        }
    }

}
