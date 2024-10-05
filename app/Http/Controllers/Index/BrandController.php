<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\Product;

class BrandController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($id)
    {
        $products = Product::where('brand_id', $id)->get();
        if (sizeof($products) == 0){
            $products = 'Пусто';
        }
        return view('brand.brand_product_show', compact('products'));
    }
}
