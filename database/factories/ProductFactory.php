<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titles = [
            'Террасная доска',
            'Бетон',
            'Песок',
            'Гипс',
            'Стеклопор',
            'Строительный блок',
            'Талатат',
            'Терразит'
        ];

        $title = Arr::random($titles);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'vendor_code' => Str::slug($title) . '-12345',
            'price' => round(rand(1000,10000),-1)/100,
            'description' => $this->faker->text,
            'list_width_full' => 1180,
            'list_width_useful' => 1120,
            'custom_length_from' => 2000,
            'custom_length_to' => 3000
        ];
    }
}
