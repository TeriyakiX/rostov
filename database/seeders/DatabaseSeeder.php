<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\Post;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Factories
        Product::factory(1)->create([
            'title' => 'Керамическая черепица (пример листа)',
            'show_calculator' => true,
            'length_list' => '1000;2000;3000;4000',
            'colors_list' => '1021;3009;4010'
        ]);
        Photo::factory(1)->create([
            'photoable_id' => 1,
            'photoable_type' => Product::class
        ]);

        Product::factory(1)->create([
            'title' => 'Металлический профиль (пример длинномерного товара)'
        ]);
        Photo::factory(1)->create([
            'photoable_id' => 2,
            'photoable_type' => Product::class
        ]);

        Product::factory(1)->create([
            'title' => 'Заклепка для профнастила (пример штучного товара)'
        ]);
        Photo::factory(1)->create([
            'photoable_id' => 3,
            'photoable_type' => Product::class
        ]);

        Product::factory(1)->create([
            'title' => 'Забор горизонтальный (пример пачки)'
        ]);
        Photo::factory(1)->create([
            'photoable_id' => 4,
            'photoable_type' => Product::class
        ]);
        ProductCategory::factory(10)->create();
        Post::factory(30)->create();

        // Custom seeders
        $this->call([
            AdminSeeder::class,
            ClientSeeder::class,
            ProductProductCategorySeeder::class,
            IndexSliderSeeder::class,
            ProductAttributesSeeder::class,
            ProductStatusSeeder::class,
        ]);

    }
}
