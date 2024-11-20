<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Inertia\Middleware;


class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        if (Auth::check()) {
            return [
                ...parent::share($request),
                'auth' => [
                    'user' => $request->user(),
                ],

                'orders_count' => Order::count(),
                'customers_count' => Customer::count(),
                'tshirts_count' => Tshirt::count(),
                'revenue' => Number::currency(
                    Order::where('status', '!=', 'cancelled')
                        ->with('tshirts')
                        ->get()
                        ->sum(function ($order) {
                            return $order->getTotalAmount();
                        })
                ),
            ];
        }
        return parent::share($request);
    }
}
