<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
        DB::table('users')->insert([
            ['id'=>1,'name' => 'Dilusha', 'email' => 'dilusha@gmailcom', 'email_verified_at'=>'' , 'password'=>'$2y$10$kol4XHJB4JL.p7BcF9AeVuF3ZKLyGuaCeNxM6lrtys0I5dXetTfm6ccvcxvxcvx' , 'last_name' => 'senavirathna' , 'phone' => '0775142377' , 'dob' =>'2024-08-04' , 'address' => 'kandy' ,'user_role'=>1 , 'username'=>'dilusha@98' , 'status'=>1 , 'remember_token'=>'' ,'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
