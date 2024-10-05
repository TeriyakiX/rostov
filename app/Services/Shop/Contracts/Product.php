<?php

namespace App\Services\Shop\Contracts;

/**
 * Interface Product
 *
 * Interface for product class implementation.
 *
 * @package App\Modules\Shop\Contracts
 */
interface Product
{
    /**
     * Calculate currency- and location-aware price with/without discount.
     *
     * @param $quantity
     * @param bool|true $withDiscount
     * @return float
     */
    public function getPrice($quantity, $withDiscount = true);
}
