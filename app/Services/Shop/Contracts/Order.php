<?php

namespace App\Services\Shop\Contracts;

/**
 * Interface Order
 *
 * Interface for order class implementation.
 *
 * @package App\Modules\Shop\Contracts
 */
interface Order
{
    /**
     * Add position to order or increment quantity if
     * position with the specified product already exists.
     *
     * @param $productId
     * @param $options
     * @return void
     */
    public function addPosition($productId, $options);

    /**
     * Remove position from order.
     *
     * @param $productId
     * @return void
     */
    public function removePosition($productId);

    /**
     * 'manyToMany' relation with product model.
     *
     * @return mixed
     */
    public function products();
}
