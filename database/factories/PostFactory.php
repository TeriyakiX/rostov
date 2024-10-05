<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'body' => $this->faker->text,
            'seo_title' => $this->faker->title,
            'seo_description' => $this->faker->text(200),
            'seo_keywords' => $this->faker->text(200),
            'active' => true,
        ];
    }
}
