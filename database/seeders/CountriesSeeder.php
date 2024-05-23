<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Countries;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'United States'],
            ['name' => 'Canada'],
            ['name' => 'United Kingdom'],
            // Add more countries as needed
        ];

        foreach ($countries as $country) {
            Countries::create($country);
        }
    }
}
