<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'percod' => 5499,
        //     'nick' => 'AWHM', 
        //     'email' => 'ariel.hidalgo@fab.bo', 
        //     'password' => Hash::make('password')
        // ]);

        $user = User::find(1);
        $user->assignRole('ACCESO TOTAL'); 
    }
}
