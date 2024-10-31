<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::insert(
            [
                [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'phone' => '+1 (555) 555-5555',
                    'country' => 'USA',
                    'city' => 'New York',
                    'address' => '123 Main St, New York, NY 10001',
                ],
                [
                    'name' => 'Jane Doe',
                    'email' => 'jane@example.com',
                    'phone' => '+1 (555) 555-5555',
                    'country' => 'USA',
                    'city' => 'Los Angeles',
                    'address' => '456 Main St, Los Angeles, CA 90001',
                ]
            ]
        );
    }
}
