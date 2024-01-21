<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_seed = [
            [
                'admin' => true,
                'name' => 'Doga Korkmaz',
                'nick_name' => 'dogaduck',
                'avatar_src' => 'images/profiles/avatars/default/male.jpeg',
                'gender' => 'male',
                'email' => 'doga@doga.com',
                'password' => Hash::make('Doga123456789'),
            ],
            [
                'admin' => false,
                'name' => 'Hazal Korkmaz',
                'nick_name' => 'hazaliko',
                'avatar_src' => 'images/profiles/avatars/default/female.jpeg',
                'gender' => 'female',
                'email' => 'yasariko@gmail.com',
                'password' => Hash::make('Hk.yasariko1'),
            ]
        ];
        DB::table('users')->insert($user_seed);
    }
}
