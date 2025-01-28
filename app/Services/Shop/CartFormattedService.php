<?php

namespace App\Services\Shop;

use App\Models\AttributeItem;
use App\Models\OptionItem;
use phpDocumentor\Reflection\Types\Collection;

class CartFormattedService
{
public function getFormattedOptionsText(array $options = [], bool $isFirst = true, \Illuminate\Support\Collection $collection, bool $excludeLength = false, bool $excludeSquare = false){
    $return = '';

    if(isset($options['attribute'])) {
        foreach ($options['attribute'] as $attributeId => $optionId) {
            $attributeItem = AttributeItem::find($attributeId);
            if($attributeItem) {
                $optionItem = OptionItem::find($optionId);
                if($optionItem) {
                    $return .= $attributeItem->title . ': ' . $optionItem->title . ' / ';
                }
            }
        }
    }

    if(isset($options['color'])&&!$isFirst) {
        $return .= 'Цвет RAL ' . $options['color'] . ' / ';
    }
    $totalSquare=0;
foreach ($collection as $item){
    if(isset($item->options['totalSquare'])) {
        $totalSquare+=$item->options['totalSquare'];
    }
}
    if (isset($options['length']) && !$isFirst && !$excludeLength) {
        $return .= 'Длина ' . $this->millsFormattedToText($options['length']) . ' / ';
    }

    if(isset($options['width']) && !$isFirst) {
        $return .= 'Ширина ' . $this->millsFormattedToText($options['width']) . ' / ';
    }

    if (isset($options['square']) && !$excludeSquare && $options['square'] != 0) {
        $return .= 'Площадь: ' . $options['square'] . 'м2 / ';
    }

    return trim(trim($return),'/');
}
    public function millsFormattedToText($length): string
    {
        if($length >= 1000) {
            return $length/1000 . ' м';
        }
        return $length . ' мм';
    }
}
