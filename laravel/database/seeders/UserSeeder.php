<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
 
class UserSeeder extends Seeder
{
   public function run()
   {
       $admin = new User([
           'name'      => config('2daw08'),
           'email'     => config('2daw.equip08@fp.insjoaquimmir.cat'),
           'password'  => Hash::make(config('DaHu2003')),
       ]);
       $admin->save();
   }
}

