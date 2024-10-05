<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class ProductService
{
    const SESSION_PRODUCTS = 'products';

    const SESSION_VIEWED = 'viewed';

    const SESSION_FAVORITES = 'favorites';

    /**
     * ProductService constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $productId
     * @param $sessionPrefix
     * @param bool $toggle
     * @return mixed
     */
    public function addToSession($productId, $sessionPrefix, $toggle = true)
    {
        $ids = $this->getSession($sessionPrefix);

        $alreadyAdded = false;

        /* add unique slugs */
        if($ids) {
            if (($key = array_search($productId, $ids)) !== false) {
                unset($ids[$key]);
                $alreadyAdded = true;
            }
            if(!$toggle || !$alreadyAdded) {
                array_unshift($ids, $productId);
            }
        } else {
            $ids[] = $productId;
        }

        /* delete old slugs */
        if (count($ids) > 10) {
            array_splice($ids, 10);
        }

        Session::put(self::SESSION_PRODUCTS . '.' . $sessionPrefix, $ids);

        return ['ids' => $ids, 'alreadyAdded' => $alreadyAdded];
    }

    /**
     * @param $sessionPrefix
     * @return mixed
     */
    public function getSession($sessionPrefix)
    {
        return Session::get(self::SESSION_PRODUCTS . '.' . $sessionPrefix, []);
    }

    /**
     * @param $part
     */
    public function flushSessionPart($part)
    {
        Session::forget(self::SESSION_PRODUCTS . '.' . $part);
    }

}
