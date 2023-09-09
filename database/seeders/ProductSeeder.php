<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id');

        for ($i = 0; $i < 20; $i++) {
            $data = [
                'product_category_id' => rand(1, 5),
                'name' => $faker->name(),
                'description' => $faker->realText(),
                'price' => 50000,
                'stock' => 10,
            ];

            Product::create($data);
        }
    }
}
