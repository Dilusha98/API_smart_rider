<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class appUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appuser')->insert([
            ['id'=>23,'name' => 'John Doe', 'email' => 'johndoe@example.com', 'password'=>'$2y$10$glk7NXaNoVt9EI0tl3BrgeChURZt8sJWRGEBtMWrJ93v9WHsQaPjC'],
        ]);
    }
}
