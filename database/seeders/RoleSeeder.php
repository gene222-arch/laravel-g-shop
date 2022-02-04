<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Administrator',
                'guard_name' => 'api',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Customer',
                'guard_name' => 'api',
                'created_at' => Carbon::now()
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}
