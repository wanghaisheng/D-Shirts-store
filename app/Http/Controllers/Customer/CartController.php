<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartPage()
    {
        return inertia('Customer/CartPage');
    }

    public function addToCart(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'tshirtId' => 'required|exists:tshirts,id',
            'tshirtTitle' => 'required|string|max:255',
            'tshirtPrice' => 'required|numeric|min:0',
            'size' => 'required|string|max:10', // Adjust size constraints as needed
            'quantity' => 'required|integer|min:1',
        ]);

        // Generate a unique ID for the cart item
        $uniqueId = md5($request->tshirtId . $request->size);

        // Get the cart from the session (or initialize an empty array if not found)
        $cart = session()->get('cart', []);

        // Check if the item already exists in the cart
        if (array_key_exists($uniqueId, $cart)) {
            return redirect()->back()->withErrors(['cart' => 'This item is already in your cart.']);
        }

        // Add the new item to the cart
        $cart[] = [
            'item_id' => $uniqueId,
            'tshirt_id' => $request->tshirtId,
            'tshirt_title' => $request->tshirtTitle,
            'tshirt_image' => $request->tshirtImage,
            'tshirt_price' => $request->tshirtPrice,
            'size' => $request->size,
            'quantity' => $request->quantity,
        ];

        // Save the updated cart back to the session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }

    public function removeFromCart(Request $request)
    {
        dd($request->all());
    }
}
