<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Laravel\Cashier\Checkout;


class CartController extends Controller
{
    // public function checkout()
    // {
    //     Stripe::setApiKey(config('services.stripe.secret'));

    //     $checkout = Session::create([
    //         'payment_method_types' => ['card'],
    //         'line_items' => [[
    //             'price_data' => [
    //                 'currency' => 'usd',
    //                 'product_data' => [
    //                     'name' => 'd-shirt',
    //                 ],
    //                 'unit_amount' => 100000,
    //             ],
    //             'quantity' => 1,
    //         ]],
    //         'mode' => 'payment',
    //         'payment_method_options' => [
    //             'card' => [
    //                 'setup_future_usage' => 'on_session', // Prevent saving card
    //             ],
    //         ],
    //         'success_url' => route('home'),
    //         'ui_mode' => 'hosted',
    //     ]);

    //     dd($checkout->url);

    //     $clientSecret = $checkout->client_secret ?? $this->retrieveClientSecret($checkout->id);

    //     return inertia('Customer/CartPage', compact('clientSecret'));
    // }

    public function cartPage()
    {
        return inertia('Customer/CartPage');
    }




    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'tshirtId' => 'required|exists:tshirts,id',
            'tshirtTitle' => 'required|string',
            'tshirtPrice' => 'required|numeric|min:0',
            'tshirtImage' => 'required|string',
            'size' => 'required|string|in:XS,S,M,L,XL,XXL',
            'quantity' => 'required|integer|min:1',
        ]);

        $uniqueId = md5($request->tshirtId . $request->size);

        $cart = session()->get('cart', []);

        $isDuplicate = collect($cart)->contains('item_id', $uniqueId);

        if ($isDuplicate) {
            return redirect()->back()->withErrors(['cart' => '"' . $request->size . '"' . ' size of this t-shirt is already in your cart']);
        }

        $cart[] = [
            'item_id' => $uniqueId,
            'tshirt_id' => $validated['tshirtId'],
            'tshirt_title' => $validated['tshirtTitle'],
            'tshirt_image' => $validated['tshirtImage'],
            'tshirt_price' => $validated['tshirtPrice'],
            'size' => $validated['size'],
            'quantity' => $validated['quantity'],
        ];

        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function increaseQuantity(Request $request)
    {
        $item_id = $request->id;
        $cart = session()->get('cart', []);

        foreach ($cart as $key => $item) {
            if ($item['item_id'] === $item_id && $item['quantity'] < 10) {
                $cart[$key]['quantity']++;
                session()->put('cart', $cart);
                return redirect()->back();
            }
        }

        return redirect()->back();
    }

    public function decreaseQuantity(Request $request)
    {
        $item_id = $request->id;
        $cart = session()->get('cart', []);

        foreach ($cart as $key => $item) {
            if ($item['item_id'] === $item_id && $item['quantity'] > 1) {
                $cart[$key]['quantity']--;
                session()->put('cart', $cart);
                return redirect()->back();
            }
        }

        return redirect()->back();
    }

    public function removeFromCart(Request $request)
    {
        $cart_before = session()->get('cart', []);

        $cart_after = array_filter($cart_before, function ($item) use ($request) {
            return $item['item_id'] !== $request->id;
        });

        // Reindex the array
        $cart_after = array_values($cart_after);

        session()->put('cart', $cart_after);

        return redirect()->back();
    }

    public function checkout(Request $request)
    {
        // Validate Checkout Form
        $validated = $request->validate([
            'fullname' => 'required|string|min:2',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|min:2',
            'zipcode' => 'required|integer',
            'country' => 'required|array',
        ]);

        // Get the cart items
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Create Customer
        $customer = Customer::create([
            'name' => $validated['fullname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'zipcode' => $validated['zipcode'],
            'country' => $validated['country']['name'],
        ]);

        // Create an unpaid order
        $order = Order::create([
            'customer_id' => $customer->id,
            'status' => OrderStatus::PENDING,
            'tracking_number' => rand(10000000, 99999999),
            'payment_status' => PaymentStatus::UNPAID,
            'payment_id' => '',
        ]);

        // Attach T-shirts from the cart to the order
        $totalTshirts = 0;
        $totalAmount = 0;

        foreach ($cart as $item) {
            $order->tshirts()->attach($item['tshirt_id'], [
                'quantity' => $item['quantity'],
                'price' => $item['tshirt_price'],
                'size' => $item['size'], // Add the size to the pivot table
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Calculate order totals
            $totalTshirts += $item['quantity'];
            $totalAmount += $item['quantity'] * $item['tshirt_price'];
        }

        // Update order totals
        $order->update([
            'total_tshirts' => $totalTshirts,
            'total_amount' => $totalAmount,
        ]);

        // Clear the cart after checkout
        session()->forget('cart');

        // Payment Processing
        // Stripe::setApiKey(config('services.stripe.secret'));
        // $checkoutSession = Session::create([
        //     'payment_method_types' => ['card'],
        //     'line_items' => [[
        //         'price_data' => [
        //             'currency' => 'usd',
        //             'product_data' => [
        //                 'name' => 'd-shirt',
        //             ],
        //             'unit_amount' => 100000,
        //         ],
        //         'quantity' => 1,
        //     ]],
        //     'mode' => 'payment',
        //     'payment_method_options' => [
        //         'card' => [
        //             'setup_future_usage' => 'on_session', // Prevent saving card
        //         ],
        //     ],
        //     'success_url' => route('home'),
        //     'ui_mode' => 'hosted',
        // ]);

        return redirect()->route('home');
        // ->json(['url' => $checkoutSession->url]);
    }
}
