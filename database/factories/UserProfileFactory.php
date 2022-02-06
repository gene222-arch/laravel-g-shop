<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'avatar_url' => $this->faker->imageUrl(400, 400, 'fashion'),
            'address_one' => $this->faker->address(),
            'address_two' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'created_at' => Carbon::now()
        ];
    }
}
