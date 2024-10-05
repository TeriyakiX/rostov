<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titles = [
            'Фасад',
            'Кровля',
            'Комплектующие кровли',
            'Теплоизоляция',
            'Гидро / Пароизоляция',
            'Жестяная мастерская',
            'Чердачные лестницы',
            'Инструмент для прорабов и строителей',
            'Крепеж',
            'Террасная доска',
            'Поликарбонат',
            'Элементы безопасности кровли'
        ];

        $title = Arr::random($titles);

        return [
            'title' => $title,
            'slug' => Str::slug($title)
        ];
    }
}
