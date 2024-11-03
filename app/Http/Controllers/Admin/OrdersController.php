<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })
            ->select('id', 'customer_id', 'total_price', 'status', 'tracking_number', 'created_at')
            ->with('customer')
            ->with(
                [
                    'tshirts.images' => function ($query) {
                        $query->where('order', 1);
                    }
                ]
            )
            ->paginate(10)
            ->through(function ($order) {
                return [
                    ...$order->toArray(),
                    'created_at' => $order->created_at->format('M d, Y H:i'),
                ];
            })
            ->withQueryString();

        $searchTerm = request()->get('search');
        return inertia('Admin/Orders', ['orders' => $orders, 'searchTerm' => $searchTerm]);
    }
}
