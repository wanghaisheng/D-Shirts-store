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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all customers and T-shirts
        $customers = Customer::all();
        $tshirts = Tshirt::all();

        for ($i = 1; $i <= 9; $i++) {
            // Select a random customer for each order
            $customer = $customers->random();

            // Generate a random number of items (1 to 5 T-shirts per order)
            $numberOfItems = rand(1, 3);
            $selectedTshirts = $tshirts->random($numberOfItems);

            $date = now()->subDays(rand(1, 90));
            // Create the order with a generated tracking number and random status
            $order = Order::create([
                'customer_id' => $customer->id,
                'status' => $this->getRandomStatus(),
                'tracking_number' => rand(10000000, 99999999), // 8-digit tracking number
                'created_at' => $date, 
            ]);

            // Attach the selected T-shirts to the order
            foreach ($selectedTshirts as $tshirt) {
                $order->tshirts()->attach($tshirt->id, [
                    'quantity' => rand(1, 2),     
                    'price' => $tshirt->price  ,
                    'created_at' => $date,   
                ]);
            }

            $order->total_tshirts = $order->getTotalTshirts();
            $order->total_amount = $order->getTotalAmount();
            $order->save();
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
