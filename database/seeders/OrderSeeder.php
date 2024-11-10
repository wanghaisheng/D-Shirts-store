<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::insert(
            [
                [
                    'customer_id' => 1,
                    'number_of_items' => 1,
                    'total_price' => 10,
                    'status' => 'pending',
                    'tracking_number' => '123456789',
                    'created_at' => now()->subDays(1),
                ],
                [
                    'customer_id' => 2,
                    'number_of_items' => 2,
                    'total_price' => 20,
                    'status' => 'processing',
                    'tracking_number' => '987654321',
                    'created_at' => now()->subDays(2),
                ]
            ]
        );
    }
}
