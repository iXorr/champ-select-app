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

        $ordersAmount = (clone $orders)->get()->count();
        $ordersTotalSum = (clone $orders)->sum('total_sum');

        $users = User::query()
            ->withCount([
                'orders' => function ($q) use ($from, $to) {
                    $q->whereBetween('created_at', [$from, $to]);                    
                }  
            ])
            ->withSum([
                'orders' => function ($q) use ($from, $to) {
                    $q->whereBetween('created_at', [$from, $to]);                    
                }  
            ], 'total_sum')
            ->get();
            
        return view('dashboard', [
            'orders_amount' => $ordersAmount,
            'orders_total_sum' => $ordersTotalSum,
            'users' => $users
        ]);
    }
}
