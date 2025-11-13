<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(OrderRequest $request): RedirectResponse
    {
        $user = $request->user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cabinet')->withErrors([
                'cart' => 'Добавьте товары в корзину, прежде чем оформлять заказ.',
            ]);
        }

        $validated = $request->validated();
        $total = $cartItems->sum(fn ($item) => $item->quantity * $item->product->price);

        DB::transaction(function () use ($user, $cartItems, $validated, $total) {
            $order = Order::create([
                'user_id' => $user->id,
                'contact_name' => $validated['contact_name'],
                'contact_phone' => $validated['contact_phone'],
                'contact_email' => $validated['contact_email'] ?? $user->email,
                'address' => $validated['address'],
                'preferred_date' => $validated['preferred_date'],
                'preferred_time' => $validated['preferred_time'],
                'payment_method' => $validated['payment_method'],
                'status' => Order::STATUS_NEW,
                'total_price' => $total,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $product->price,
                ]);

                $product->decrement('stock', $cartItem->quantity);
                $product->increment('sold', $cartItem->quantity);
            }

            $user->cartItems()->delete();
        });

        return redirect()->route('cabinet')->with('success', 'Заказ сформирован. Мы свяжемся с вами для подтверждения.');
    }

    public function destroy(Request $request, Order $order): RedirectResponse
    {
        $user = $request->user();

        if ($order->user_id !== $user->id || $order->status !== Order::STATUS_NEW) {
            abort(403);
        }

        $order->load('items.product');

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
                $item->delete();
            }

            $order->delete();
        });

        return redirect()->route('cabinet')->with('success', 'Заказ удален.');
    }
}
