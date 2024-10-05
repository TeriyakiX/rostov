<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstCategory = ProductCategory::first();
        if($firstCategory) {
            $products = Product::all();
            foreach($products as $product) {
                $firstCategory->products()->attach($product);
            }
        }
    }
}
