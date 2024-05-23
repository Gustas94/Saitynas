<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Countries, Cities, and Hobbies
        $this->call([
            CountriesSeeder::class,
            CitiesSeeder::class,
            HobbiesSeeder::class,
            ProductSeeder::class,
        ]);

        // Seed users
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
