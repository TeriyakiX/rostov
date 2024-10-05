<?php

namespace App\Services\Shop\Providers;

use \Illuminate\Support\ServiceProvider;
use \App\Services\Shop\CartService;

class CartServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cart', function ($app) {
            return new CartService();
        });
    }
}
