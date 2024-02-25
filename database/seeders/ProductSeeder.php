<?php

namespace Database\Seeders;

use App\Enums\Currency;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Testing\Fakes\Fake;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $units = Unit::all();

        for ($i = 0; $i < 100; $i++)
        {
            Product::create([
                'category_id' => $categories->random()->id,
                'name' => fake()->text(),
                'description' => fake()->paragraph(),
                'unit_price' => random_int(10, 500),
                'currency' => Currency::NPR,
                'available_quantity' => random_int(0, 100),
                'unit_id' => $units->random()->id,
            ]);
        }
    }
}
