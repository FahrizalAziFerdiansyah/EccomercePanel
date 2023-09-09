<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;


class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id');
        $dataCategory = ['tags', 'male', 'suitcase', 'coffee', 'cutlery'];

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'name' => $faker->name(),
                'description' => $faker->realText(),
                'icon' => $dataCategory[$i]
            ];
            ProductCategory::create($data);
        }
    }
}
