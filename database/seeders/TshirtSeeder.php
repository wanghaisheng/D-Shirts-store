<?php

namespace Database\Seeders;

use App\Models\Tshirt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TshirtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tshirt::insert(
            [
                [
                    'title' => 'T-shirt',
                    'description' => 'This is a sample t-shirt description',
                    'price' => 10,
                ],
                [
                    'title' => 'T-shirt',
                    'description' => 'This is a sample t-shirt description',
                    'price' => 20,
                ]
            ]
        );
    }
}
