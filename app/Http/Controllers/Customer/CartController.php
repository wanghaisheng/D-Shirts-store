<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartPage(Request $request)
    {
        return inertia('Customer/CartPage');
    }
}
