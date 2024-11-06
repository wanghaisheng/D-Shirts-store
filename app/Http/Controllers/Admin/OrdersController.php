<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::select('id', 'customer_id', 'total_price', 'status', 'tracking_number', 'created_at')
            ->with('customer')
            ->with([
                'tshirts.images' => function ($query) {
                    $query->where('order', 1);
                }
            ])
            ->paginate(10)
            ->through(function ($order) {
                return [
                    ...$order->toArray(),
                    'created_at' => $order->created_at->format('M d, Y H:i'),
                ];
            });
        return inertia('Admin/Orders', ['orders' => $orders]);
    }

    public function update(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required',
            'tracking_number' => 'min:8',
        ]);
        $order = Order::findOrFail($orderId);
        $order->status = $request->status['value'];
        $order->tracking_number = $request->tracking_number;
        $order->save();

        return redirect()->route('orders');
    }
}
