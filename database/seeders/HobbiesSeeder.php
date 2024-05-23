<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hobbies;

class HobbiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = [
            ['name' => 'Reading'],
            ['name' => 'Traveling'],
            ['name' => 'Cooking'],
            ['name' => 'Gardening'],
            ['name' => 'Swimming'],
            ['name' => 'Hiking'],
            ['name' => 'Photography'],
            ['name' => 'Painting'],
            // Add more hobbies as needed
        ];

        foreach ($hobbies as $hobby) {
            Hobbies::create($hobby);
        }
    }
}
