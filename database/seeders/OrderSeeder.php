<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Tshirt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch all customers and T-shirts
        $customers = Customer::all();
        $tshirts = Tshirt::all();

        for ($i = 1; $i <= 88; $i++) {
            // Select a random customer for each order
            $customer = $customers->random();

            // Generate a random number of items (1 to 5 T-shirts per order)
            $numberOfItems = rand(1, 3);
            $selectedTshirts = $tshirts->random($numberOfItems);

            // Determine the time period for this order
            $date = $this->getRandomDate();

            // Create the order with a generated tracking number and random status
            $order = Order::create([
                'customer_id' => $customer->id,
                'status' => $this->getRandomStatus(),
                'tracking_number' => rand(10000000, 99999999), // 8-digit tracking number
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // Attach the selected T-shirts to the order
            foreach ($selectedTshirts as $tshirt) {
                $order->tshirts()->attach($tshirt->id, [
                    'quantity' => rand(1, 2),
                    'price' => $tshirt->price,
                    'created_at' => $date,
                ]);
            }

            // Update order totals
            $order->total_tshirts = $order->getTotalTshirts();
            $order->total_amount = $order->getTotalAmount();
            $order->save();
        }
    }

    /**
     * Generate a random date for orders based on different time periods.
     */
    private function getRandomDate(): \Carbon\Carbon
    {
        $period = rand(1, 4);

        switch ($period) {
            case 1: // All Time (last 5 years)
                return now()->subYears(rand(1, 5))->subMonths(rand(0, 11))->subDays(rand(0, 30));
            case 2: // This Year (last 12 months)
                return now()->subMonths(rand(0, 11))->subDays(rand(0, 30));
            case 3: // This Month (last 30 days)
                return now()->subDays(rand(0, 30));
            case 4: // Last Year (specific to the previous calendar year)
                return now()->subYear()->subMonths(rand(0, 11))->subDays(rand(0, 30));
            default:
                return now();
        }
    }

    /**
     * Get a random order status.
     */
    private function getRandomStatus(): string
    {
        $statuses = ['pending', 'processing', 'delivered', 'cancelled'];
        return $statuses[array_rand($statuses)];
    }
}
