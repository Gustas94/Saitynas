<?php

// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 1000; $i++) {
            $specifications = collect([
                ['Screen Size', $faker->randomElement(['24"', '27"', '32"', '34"'])],
                ['Resolution', $faker->randomElement(['1920x1080', '2560x1440', '3840x2160'])],
                ['Refresh Rate', $faker->randomElement(['60Hz', '75Hz', '120Hz', '144Hz'])],
                ['Brand', $faker->randomElement(['Samsung', 'LG', 'Dell', 'HP', 'Asus'])],
                ['Response Time', $faker->randomElement(['1ms', '2ms', '5ms', '10ms'])],
            ])->map(function ($item) {
                return implode(': ', $item);
            })->implode('; ');

            Product::create([
                'name' => $faker->words(3, true), // Generating a product-like name
                'category' => $faker->randomElement(['phones', 'headphones', 'monitors']),
                'description' => $faker->paragraph,
                'specifications' => $specifications,
                'price' => $faker->randomFloat(2, 100, 2000),
            ]);
        }
    }
}


