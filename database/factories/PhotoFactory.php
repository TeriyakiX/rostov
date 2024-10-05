<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Photo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /**
        *  $table->string('path');
        *  $table->unsignedBigInteger('photoable_id')->nullable();
        *  $table->string('photoable_type')->nullable();
         */
        return [
            'path' => '1127202120532861a29ac8a0c6a.jpg'
        ];
    }
}
