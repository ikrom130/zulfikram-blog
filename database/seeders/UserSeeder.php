<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()-> create([
            'name' => 'Otong Surotong',
            'username' => 'sslmasohi',
            'email' => 'sslmasohi@gmail.com',
            'password' => Hash::make('Ssl#1234'),
        ]);

        User::factory(3)->create();
    }
}
