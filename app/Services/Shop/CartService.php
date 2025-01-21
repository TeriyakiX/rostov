<?php

namespace App\Services\Shop;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Class CartService
 *
 * Singleton that provides cart API.
 *
 * @package App\Modules\Shop
 */
class CartService
{
    /**
     * Cart session key.
     */
    const SESSION_KEY = 'cart';


    /**
     * Cart session key for products.
     */
    const SESSION_KEY_PRODUCTS = self::SESSION_KEY . '.products';

	/**
	 * Cart session key for products.
	 */
	const SESSION_KEY_PRODUCTS_SIZES = self::SESSION_KEY . '.products_sizes';

    /**
     * Cart positions collection.
     *
     * @var \Illuminate\Support\Collection
     */
    private $_positions;


    private  $_formattedCart;
    /**
     * Total price for the cart positions.
     *
     * @var int
     */
    private $_totalPrice;

    /**
     * Total quantity of products in cart positions.
     *
     * @var int
     */
    private $_totalQuantity;

    /**
     * Boot the service by collecting positions and counting summaries.
     */
    public function boot()
    {
        $this->commit();
    }

    /**
     * Collect positions and calculate summaries.
     */
    public function commit()
    {
        $this->_positions = collect([]);
        $this->_totalPrice = 0;
        $this->_totalQuantity = 0;

        foreach (Session::get($this::SESSION_KEY_PRODUCTS, []) as $productId => $options) {
            $product = Product::find($productId);

            if ($product) {

                $positionInstance = new CartPosition($product, $options,$productId);
                $this->_positions->push($positionInstance);
                $this->_totalPrice += $positionInstance->getTotalPrice();
                $this->_totalQuantity += $positionInstance->getQuantity();
            }

        }
        $collection=new Collection();

        foreach ($this->_positions as $position){

            $productId=$position->getProduct()->id;

            $collection->push((object)['product'=>$position->getProduct(),'product_id'=>$productId,'options'=>$position->getOptions(),'quantity'=>$position->getQuantity()
            ,'total_price'=>$position->getTotalPrice(),'productSessionId'=>$position->getProductId()]);
        }

        $this->_formattedCart= $collection->groupBy('product_id');

//        dd($productArr,collect(Product::whereIn('id',$productArr)->groupBy('id')->get()),$this->_positions);
    }

    /**
     * Empty cart.
     */
    public function flush()
    {
        Session::pull('cart');
            $this->commit();
    }

    /**
     * Validate and add position to cart.
     * Return true if position added.
     *
     * @param $productId
     * @param array $options
     * @return bool
     */
    public function addPosition($productId, $options = [])
    {

        if ($this->validatePosition($productId))
        {
            $sessionKey = $this::SESSION_KEY_PRODUCTS . '.' . $productId;



            Session::put($sessionKey, $options);

            return true;
        }

        return false;
    }


    /**
     * Validate and add position to cart.
     * Return true if position added.
     *
     * @param $productId
     * @param array $options
     * @return bool
     */
    public function setPosition($productId, $options = [])
    {

        if ($this->validatePosition($productId))
        {
            if (isset($options['length'])){
                $sessionKey = $this::SESSION_KEY_PRODUCTS . '.' . $productId . 'length=' .$options['length'];

            }
          else{
              $sessionKey = $this::SESSION_KEY_PRODUCTS . '.' . $productId;
          }

            Session::put($sessionKey, $options);
            return true;
        }

        return false;
    }

    public function setPositionAlt($productId,$key, $options = [])
    {

        if ($this->validatePosition($productId))
        {
            Session::put($key, $options);
            return true;
        }

        return false;
    }

    /**
     * Remove position from cart if it exists in cart.
     * Return true if position removed.
     *
     * @param $productId
     * @return bool
     */
    public function removePosition($productId)
    {
        $sessionKey = $this::SESSION_KEY_PRODUCTS . '.' . $productId;
        if (Session::pull($sessionKey) !== null) {
            return true;
        }
        return false;
    }

    /**
     * Check if product exists and quantity is positive integer.
     *
     * @param $productId
     * @param $quantity
     * @return bool
     */
    public function validatePosition($productId)
    {
        $rules = [
            'id' => ['required', 'numeric', 'exists:products,id']
        ];
        return Validator::make(['id' => $productId], $rules)
            ->passes();
    }

	/**
	 * Check if product exists in cart.
	 *
	 * @param int $id
	 * @return bool
	 */
    public function isProductInCart($id)
    {
    	$isProductInCart = false;
    	$positions = $this->getPositions();
    	foreach ($positions as $position) {
    		if($id == $position->getProduct()->id) {
			    $isProductInCart = true;
			    break;
		    }
	    }

	    return $isProductInCart;
    }

    /**
     * Getter for cart positions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPositions()
    {

        return $this->_positions ;
    }

    /**
     * Getter for total price of cart positions.
     *
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->_totalPrice;
    }
    public function getFormattedCart()
    {
        return $this->_formattedCart;
    }
    /**
     * Getter for total number of products in cart positions.
     *
     * @return int
     */
    public function getTotalQuantity()
    {
        return $this->_totalQuantity;
    }

    public function flushSessionPart($part)
    {
        Session::forget(self::SESSION_KEY_PRODUCTS . '.' . $part);
    }
    public function getSession($sessionPrefix)
    {
        return Session::get(self::SESSION_KEY_PRODUCTS . '.' . $sessionPrefix, []);
    }
}
