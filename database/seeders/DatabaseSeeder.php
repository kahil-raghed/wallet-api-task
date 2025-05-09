<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::unguard();
        User::query()->delete();

        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('12345678'),
            'balance' => 1000
        ]);

        User::create([
            'first_name' => 'User',
            'last_name' => '2',
            'email' => 'user2@example.com',
            'password' => Hash::make('12345678'),
            'balance' => 200
        ]);
    }
}
