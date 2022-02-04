<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'barcode' => $this->faker->unique()->randomDigit(),
            'sku' => $this->faker->unique()->randomDigit(),
            'image_url' => $this->faker->imageUrl(400, 400, 'fashion'),
            'title' => $this->faker->title(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomDigit(),
            'created_at' => $this->faker->unique()->dateTime()
        ];
    }
}
