<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $from = now()->subDays(3);

        $base = Order::where('orders.created_at', '>=', $from);

        $totalOrders = (clone $base)->count();
        $totalSum = (clone $base)->sum('total_sum');

        $byUser = (clone $base)
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select(
                'orders.user_id',
                'users.full_name',
                'users.login',
                'users.role',
                DB::raw('count(*) as orders_count'),
                DB::raw('sum(total_sum) as orders_sum')
            )
            ->groupBy('orders.user_id', 'users.full_name', 'users.login', 'users.role')
            ->get();

        return view('dashboard', [
            'total_orders' => $totalOrders,
            'total_sum' => $totalSum,
            'users' => $byUser,
            'from' => $from,
        ]);
    }
}
