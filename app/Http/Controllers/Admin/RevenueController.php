<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTshirt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index()
    {
        $chartData = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), 
            DB::raw('SUM(total_amount) as monthly_income'),
            DB::raw('SUM(total_tshirts) as monthly_tshirts'),
            DB::raw('COUNT(*) as monthly_order'), 
            DB::raw('SUM(SUM(total_amount)) OVER (ORDER BY DATE_FORMAT(created_at, "%Y-%m")) as cumulative_income') 
        )
            ->where('status', '!=', 'cancelled')
            ->groupBy('month')
            ->get();

        return inertia('Admin/Revenue', compact('chartData'));
    }


}
