<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Super Administrator',
            'email' => 'superadministrator@gmail.com',
            'password' => Hash::make('superadministrator@gmail.com')
        ]);
    }
}
