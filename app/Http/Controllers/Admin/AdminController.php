<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'totalOrders' => Order::count(),
            'newOrders' => Order::where('status', Order::STATUS_NEW)->count(),
            'inProgress' => Order::where('status', Order::STATUS_IN_PROGRESS)->count(),
            'doneOrders' => Order::where('status', Order::STATUS_DONE)->count(),
            'products' => Product::count(),
            'clients' => User::where('role', 'client')->count(),
        ];

        $latestOrders = Order::with('user')->latest()->limit(5)->get();

        return view('pages.admin.dashboard', compact('stats', 'latestOrders'));
    }
}
