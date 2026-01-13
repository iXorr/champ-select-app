<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['client', 'user', 'items.product'])
            ->orderByDesc('orders.created_at');

        if (!$request->user()->isAdmin()) {
            $query->where('user_id', $request->user()->id);
        }

        $filters = [
            'status' => $request->query('status'),
            'user_id' => $request->query('user_id'),
            'client_id' => $request->query('client_id'),
            'created_from' => $request->query('created_from'),
            'created_to' => $request->query('created_to'),
            'shipped_from' => $request->query('shipped_from'),
            'shipped_to' => $request->query('shipped_to'),
        ];

        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }

        if ($filters['user_id']) {
            $query->where('user_id', $filters['user_id']);
        }

        if ($filters['client_id']) {
            $query->where('client_id', $filters['client_id']);
        }

        if ($filters['created_from']) {
            $query->whereDate('orders.created_at', '>=', $filters['created_from']);
        }

        if ($filters['created_to']) {
            $query->whereDate('orders.created_at', '<=', $filters['created_to']);
        }

        if ($filters['shipped_from']) {
            $query->whereDate('shipped_at', '>=', $filters['shipped_from']);
        }

        if ($filters['shipped_to']) {
            $query->whereDate('shipped_at', '<=', $filters['shipped_to']);
        }

        return view('orders.index', [
            'orders' => $query->get(),
            'statuses' => Order::STATUSES,
            'clients' => Client::orderBy('full_name')->get(),
            'users' => User::orderBy('full_name')->get(),
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        return view('orders.create', [
            'clients' => Client::orderBy('full_name')->get(),
            'products' => Product::orderBy('title')->get(),
            'statuses' => Order::STATUSES,
        ]);
    }

    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        $status = $data['status'] ?? Order::STATUSES[0];
        $shippedAt = $data['shipped_at'] ?? null;

        if ($status !== Order::STATUSES[0] && $status !== 'Отменён' && !$shippedAt) {
            $shippedAt = now();
        }

        $order = Order::create([
            'client_id' => $data['client_id'],
            'user_id' => $user->id,
            'status' => $status,
            'shipped_at' => $shippedAt,
        ]);

        $total = $this->syncItems($order, $data['items'] ?? []);

        $order->update(['total_sum' => $total]);

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Заказ создан');
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'client', 'user']);

        return view('orders.show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function edit(Order $order)
    {
        $order->load(['items.product', 'client', 'user']);

        return view('orders.edit', [
            'order' => $order,
            'clients' => Client::orderBy('full_name')->get(),
            'products' => Product::orderBy('title')->get(),
            'statuses' => Order::STATUSES,
        ]);
    }

    public function update(OrderRequest $request, Order $order)
    {
        $data = $request->validated();

        $newStatus = $data['status'] ?? $order->status;

        if (!$this->canMoveStatus($order->status, $newStatus)) {
            return back()->withErrors([
                'status' => 'Назад переходить нельзя',
            ])->withInput();
        }

        $shippedAt = $data['shipped_at'] ?? $order->shipped_at;

        if ($order->status === Order::STATUSES[0] && $newStatus !== Order::STATUSES[0] && $newStatus !== 'Отменён' && !$shippedAt) {
            $shippedAt = now();
        }

        $total = $order->total_sum;

        if (array_key_exists('items', $data)) {
            $total = $this->syncItems($order, $data['items'] ?? []);
        }

        $order->update([
            'client_id' => $data['client_id'] ?? $order->client_id,
            'status' => $newStatus,
            'shipped_at' => $shippedAt,
            'total_sum' => $total,
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Заказ обновлен');
    }

    public function destroy(Order $order)
    {
        $order->update(['status' => 'Отменён']);

        return redirect()
            ->route('orders.index')
            ->with('status', 'Заказ отменен');
    }

    private function syncItems(Order $order, array $items): int
    {
        $order->items()->delete();

        $total = 0;

        foreach ($items as $item) {
            if (!isset($item['product_id'], $item['quantity'])) {
                continue;
            }

            $product = Product::findOrFail($item['product_id']);
            $discount = $item['discount'] ?? 0;
            $quantity = $item['quantity'];

            $sum = (int)round(
                ($product->price - ($product->price / 100 * $discount))
                * $quantity
            );

            $order->items()->create([
                'product_id' => $product->id,
                'discount' => $discount,
                'quantity' => $quantity,
                'sum' => $sum,
            ]);

            $total += $sum;
        }

        return $total;
    }

    private function canMoveStatus(string $current, string $next): bool
    {
        $order = array_flip(Order::STATUSES);

        if (!isset($order[$current], $order[$next])) {
            return false;
        }

        return $order[$next] >= $order[$current];
    }
}
