<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductStatus::create([
            'title' => 'Опубликован'
        ]);

        ProductStatus::create([
            'title' => 'Не опубликован'
        ]);

        ProductStatus::create([
            'title' => 'В архиве'
        ]);
    }
}
