<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\CustomersFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UserSeeder::class, CustomerSeeder::class, TshirtSeeder::class, OrderSeeder::class, OrderTshirtsSeeder::class, TshirtImageSeeder::class]);
    }
}
