<?php

namespace App\Services\Shop;

use App\Models\AttributeItem;
use App\Models\OptionItem;
use App\Services\RalToRgb;
use \App\Services\Shop\Contracts\Product;

class CartPosition
{
    /**
     * Position's Product model.
     *
     * @var Product
     */
    private $_product;

    /**
     * Position's options.
     *
     * @var array
     */
    private $_options;
    /**
     * Product SessionId.
     *
     * @var string
     */
    private $_product_id;

    /**
     * Position's quantity.
     *
     * @var int
     */
    private $_quantity;

    /**
     * Total price for the position.
     *
     * @var int
     */
    private $_totalPrice;

    /**
     * Item price for the position.
     *
     * @var int
     */
    private $_itemPrice;

    protected $ralToRgb;

    /**
     * Construct report of given product instance and quantity.
     *
     * @param Product $product
     * @param $options
     */
    public function __construct(Product $product, $options,$productId)
    {
        $this->_product = $product;
        $this->_product_id=$productId;
        $this->_options = $options ?? [];
        $this->_quantity = $options['quantity'] ?? 1;
        $this->_itemPrice = $options['price'] ?? 0;
        $this->_totalPrice = $options['totalPrice'] ?? 0;

//        $this->ralToRgb = new RalToRgb();
    }

    /**
     * Getter for product.
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->_product;
    }
    /**
     * Getter for productId.
     *
     * @return string
     */
    public function getProductId(): string
    {
        return $this->_product_id;
    }
    /**
     * Getter for options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Getter for quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * Getter for total price.
     *
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->_totalPrice;
    }

    /**
     * Getter for item price.
     *
     * @return int
     */
    public function getItemPrice()
    {
        return $this->_itemPrice;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        $product = $this->getProduct();
        return ($product ? $product->title : null);
    }

    /**
     * @return string|null
     */
    public function getPhotoPath()
    {
        $product = $this->getProduct();
        return ($product ? $product->mainPhotoPath() : null);
    }

    /**
     * @return string|null
     */
    public function getProductUrl()
    {
        $product = $this->getProduct();
        if($product) {
            $category = $product->categories()->first();
            if($category) {
                return route('index.products.show', ['product' => $product->slug, 'category' => $category->slug]);
            }
        }
        return '#';
    }

    /**
     * @return string
     */
    public function getOptionsText()
    {
        $return = '';
        $options = $this->_options;

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

        if(isset($options['color'])) {
            $return .= 'Цвет RAL ' . $options['color'] . ' / ';
        }

        if(isset($options['length'])) {
            $return .= 'Длина ' . $this->millsToText($options['length']) . ' / ';
        }

        if(isset($options['width'])) {
            $return .= 'Ширина ' . $this->millsToText($options['width']) . ' / ';
        }

        if(isset($options['totalSquare'])) {
            $return .= 'Общая площадь: ' . $options['totalSquare'] . 'м2 / ';
        }

        return trim(trim($return),'/');
    }

    /**
     * @param $length
     * @return string
     */
    public function millsToText($length) {
        if($length >= 1000) {
            return $length/1000 . ' м';
        }
        return $length . ' мм';
    }
}
