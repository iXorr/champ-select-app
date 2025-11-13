<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();

        $orders = Order::with(['user', 'items.product'])
            ->forStatus($status)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pages.admin.orders.index', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in([
                Order::STATUS_NEW,
                Order::STATUS_IN_PROGRESS,
                Order::STATUS_DONE,
                Order::STATUS_CANCELED,
            ])],
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        if ($data['status'] === Order::STATUS_CANCELED && empty($data['cancellation_reason'])) {
            return back()->withErrors([
                'cancellation_reason' => 'Для отмены необходимо указать причину.',
            ]);
        }

        $order->update([
            'status' => $data['status'],
            'cancellation_reason' => $data['status'] === Order::STATUS_CANCELED ? $data['cancellation_reason'] : null,
        ]);

        return back()->with('success', 'Статус заказа обновлен.');
    }
}
