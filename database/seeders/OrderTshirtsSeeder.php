<?php

namespace Database\Seeders;

use App\Models\OrderTshirt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderTshirtsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderTshirt::insert(
            [
                [
                    'order_id' => 1,
                    'tshirt_id' => 1,
                ],
                [
                    'order_id' => 1,
                    'tshirt_id' => 2,
                ],
                [
                    'order_id' => 2,
                    'tshirt_id' => 1,
                ]
            ]
        );
    }
}
