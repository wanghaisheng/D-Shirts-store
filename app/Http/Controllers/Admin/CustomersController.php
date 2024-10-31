<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customer::select('id', 'name', 'email', 'phone', 'country', 'city', 'address')
        ->withCount('orders')  // Adds an 'orders_count' attribute for the total order count
        ->withSum('orders', 'total_price')  // Adds an 'orders_sum_total_price' attribute for total revenue
        ->get();
        return inertia('Admin/Customers', compact('customers'));
    }
}
