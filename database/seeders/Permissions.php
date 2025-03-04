<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_permissions')->insert([
            ['upi'=>2,'tle' => 'dashboard', 'dpt'=> 'Dashboard','typ' => 'dashboard'],
            ['upi'=>4,'tle' => 'user', 'dpt'=> 'User','typ' => 'user'],
            ['upi'=>5,'tle' => 'create_user_role', 'dpt' => 'Create User Role','typ' => 'user'],
            ['upi'=>6,'tle' => 'assign_permissions', 'dpt'=> 'Assign Permissions','typ' => 'user'],
            ['upi'=>7,'tle' => 'user_role_list', 'dpt'=> 'User Role List','typ' => 'user'],
            ['upi'=>8,'tle' => 'create_user', 'dpt'=> 'Create User','typ' => 'user'],
            ['upi'=>9,'tle' => 'user_list', 'dpt'=> 'User List','typ' => 'user'],
            ['upi'=>10,'tle' => 'user_edit', 'dpt'=> 'User Edit','typ' => 'user'],
            ['upi'=>11,'tle' => 'user_role_edit', 'dpt'=> 'User Role Edit','typ' => 'user'],
        ]);
    }
}
