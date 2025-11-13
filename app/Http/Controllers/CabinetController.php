<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CabinetController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $cartItems = $user->cartItems()
            ->with('product.category')
            ->orderByDesc('created_at')
            ->get();

        $cartTotal = $cartItems->sum(fn ($item) => $item->quantity * $item->product->price);

        $orders = $user->orders()
            ->with(['items.product'])
            ->latest()
            ->get();

        return view('pages.cabinet.index', [
            'user' => $user,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'orders' => $orders,
        ]);
    }
}
