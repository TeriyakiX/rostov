<?php

namespace App\Services\Shop\Middleware;

use \Closure;

/**
 * Class BootCart
 *
 * @package App\Modules\Shop\Middleware
 */
class BootCart
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle($request, Closure $next)
    {
        $cart = app()->make('cart');
        $cart->boot();
        return $next($request);
    }
}
