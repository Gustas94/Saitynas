<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cities;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'New York', 'country_id' => 1], // Assuming 'United States' has id 1
            ['name' => 'Los Angeles', 'country_id' => 1],
            ['name' => 'Toronto', 'country_id' => 2], // Assuming 'Canada' has id 2
            ['name' => 'Vancouver', 'country_id' => 2],
            ['name' => 'London', 'country_id' => 3], // Assuming 'United Kingdom' has id 3
            ['name' => 'Manchester', 'country_id' => 3],
            // Add more cities as needed
        ];

        foreach ($cities as $city) {
            Cities::create($city);
        }
    }
}
