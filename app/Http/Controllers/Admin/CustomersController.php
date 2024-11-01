<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        })
        ->select('id', 'name', 'email', 'phone', 'country', 'city', 'address')
        ->withCount('orders')  // Adds an 'orders_count' attribute for the total order count
        ->withSum('orders', 'total_price')  // Adds an 'orders_sum_total_price' attribute for total revenue
        ->paginate(10)->withQueryString();
        $searchTerm = request()->get('search');
        return inertia('Admin/Customers', compact('customers', 'searchTerm'));
    }
}
