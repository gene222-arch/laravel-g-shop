<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
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
                'name' => 'Manage Products',
                'guard_name' => 'api',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Users',
                'guard_name' => 'api',
                'created_at' => Carbon::now()
            ]
        ];

        DB::table('permissions')->insert($roles);
    }
}
