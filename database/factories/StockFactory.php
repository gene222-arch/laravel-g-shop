<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::first()->id,
            'in_stock' => $this->faker->randomDigit(),
            'incoming_stock' => $this->faker->randomDigit(),
            'stock_out' => $this->faker->randomDigit(),
            'bad_stock' => $this->faker->randomDigit(),
        ];
    }
}
