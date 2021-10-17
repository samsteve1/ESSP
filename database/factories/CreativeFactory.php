<?php

namespace Database\Factories;

use App\Models\Creative;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreativeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Creative::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path' =>  'test' //$this->faker->imageUrl($width = 640, $height = 480)
        ];
    }
}
