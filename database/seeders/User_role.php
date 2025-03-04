<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class User_role extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roles')->insert([
            ['id'=>1,'title' => 'admin', 'created_by' => 1, 'updated_by'=>1 ,'updated_at' => now(),'created_at' => now(),'status'=>1],
            ['id'=>2,'title' => 'dev', 'created_by' => 1, 'updated_by'=>1 ,'updated_at' => now(),'created_at' => now(),'status'=>1],
            ['id'=>3,'title' => 'supervisor', 'created_by' => 1, 'updated_by'=>1 ,'updated_at' => now(),'created_at' => now(),'status'=>1],
            ['id'=>4,'title' => 'hr', 'created_by' => 1, 'updated_by'=>1 ,'updated_at' => now(),'created_at' => now(),'status'=>1],
            ['id'=>5,'title' => 'driver', 'created_by' => 1, 'updated_by'=>1 ,'updated_at' => now(),'created_at' => now(),'status'=>1],
        ]);
    }
}
