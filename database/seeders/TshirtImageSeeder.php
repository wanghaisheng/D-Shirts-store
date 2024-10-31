<?php

namespace Database\Seeders;

use App\Models\ShirtImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TshirtImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShirtImage::insert([
            [
                'order' => 1,
                'tshirt_id' => 1,
                'url' => 'https://via.placeholder.com/150',
            ],
            [
                'order' => 1,
                'tshirt_id' => 2,
                'url' => 'https://via.placeholder.com/150',
            ]
        ]);
    }
}
