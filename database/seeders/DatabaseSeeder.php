<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([PostSeeder::class]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '09887538',
            'address' => 'yangon',
            'role' => 'admin',
            'gender' => 'Male',
            'password' => Hash::make('password')
        ]);
    }
}
