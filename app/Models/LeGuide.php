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
            case 'occasion':
                return $this->formatCondition($value);
            default:
                return parent::transformValue($attributeKey, $value);
        }
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
