<?php

namespace Database\Seeders;

use App\Models\Farmer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Farmer::create([
            'name' => 'Test Farmer',
            'email' => 'test@farmer.com',
            'password' => 'password',
        ]);

        $user->markEmailAsVerified();
    }
}
