<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('save_permissions')->insert([
            ['id'=>1,'user_role' => 1, 'permission' => 2],
            ['id'=>2,'user_role' => 1, 'permission' => 4],
            ['id'=>3,'user_role' => 1, 'permission' => 5],
            ['id'=>4,'user_role' => 1, 'permission' => 6],
            ['id'=>5,'user_role' => 1, 'permission' => 7],
            ['id'=>6,'user_role' => 1, 'permission' => 8],
            ['id'=>7,'user_role' => 1, 'permission' => 9],
            ['id'=>8,'user_role' => 1, 'permission' => 10],
            ['id'=>9,'user_role' => 1, 'permission' => 11],
        ]);
    }
}
