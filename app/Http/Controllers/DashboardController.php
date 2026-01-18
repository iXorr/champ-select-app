<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $from = now()->subDays(2)->startOfDay();
        $to = now()->endOfDay();

        $orders = Order::whereBetween('created_at', [$from, $to]);

        $totalOrders = (clone $orders)->count();
        $totalSum = (clone $orders)->sum('total_sum');

        $ordersByUser = (clone $orders)
            ->selectRaw('user_id, count(*) as orders_count')
            ->groupBy('user_id')
            ->with('user')
            ->get();

        $sumByUser = (clone $orders)
            ->selectRaw('user_id, sum(total_sum) as total_sum')
            ->groupBy('user_id')
            ->with('user')
            ->get()
            ->keyBy('user_id');

        return view('dashboard', compact(
            'totalOrders',
            'totalSum',
            'ordersByUser',
            'sumByUser'
        ));
    }
}
