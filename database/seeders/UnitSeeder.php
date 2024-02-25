<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'name' => 'kilograms',
            'symbol' => 'kg'
        ]);

        Unit::create([
            'name' => 'grams',
            'symbol' => 'gm'
        ]);

        Unit::create([
            'name' => 'pieces',
            'symbol' => 'pcs'
        ]);

    }
}
