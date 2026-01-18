<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Client;
use App\Models\Product;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\ChangeOrderStatusRequest;

class OrderController extends Controller
{
    private function syncItems(Order $order, array $items)
    {
        $order->items()->delete();

        $totalSum = 0;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            $sum = (int)($item['quantity'] * $product->price);
            $calcSum = (int)($sum - ($sum / 100 * $item['discount'] ?? 0));

            $totalSum += $calcSum;

            OrderItem::create([
                ...$item,
                'order_id' => $order->id,
                'sum' => $calcSum
            ]);
        }

        return $totalSum;
    }

    public function index()
    {
        return view('orders.index', [
            'orders' => Order::all(),
            'users' => User::all(),
            'clients' => Client::all()
        ]);
    }

    public function filter(Request $request)
    {
        $orders = Order::query();

        if ($request->input('status'))
            $orders->where('status', $request->input('status'));
        
        if ($request->input('user_id'))
            $orders->where('user_id', $request->input('user_id'));
        
        if ($request->input('client_id'))
            $orders->where('client_id', $request->input('client_id'));
        
        if ($request->input('created_at'))
            $orders->whereDate('created_at', $request->input('created_at'));

        if ($request->input('shipped_at'))
            $orders->whereDate('shipped_at', $request->input('shipped_at'));

        $orders = $orders->get();

        return view('orders.partials.table', [
            'orders' => $orders
        ]);
    }

    public function create()
    {
        return view('orders.create', [
            'clients' => Client::all(),
            'products' => Product::all()
        ]);
    }

    public function store(OrderRequest $request)
    {
        $data = $request->validated();

        $order = Order::create([
            'client_id' => $data['client_id'],
            'user_id' => $request->user()->id,
            'status' => 'Новый'
        ]);

        $data['total_sum'] = $this->syncItems($order, $data['items']);
        
        $order->update(['total_sum' => $data['total_sum']]);

        return redirect()
            ->route('orders.index')
            ->with('message', 'Заказ создан');
    }

    public function edit(Order $order)
    {
        if ($order->status !== 'Новый')
            return back()
                ->withErrors(['Менять можно только новые заказы']);

        return view('orders.edit', [
            'order' => $order,
            'clients' => Client::all(),
            'products' => Product::all()
        ]);
    }

    public function updateStatus(ChangeOrderStatusRequest $request, Order $order)
    {
        $data = $request->validated();

        $statuses = ['Новый', 'Отгрузка', 'Доставка', 'Выдан', 'Отменен'];

        $currentStatus = $order->status;
        $newStatus = $data['status'];

        $currentIndex = array_search($currentStatus, $statuses, true);
        $newIndex = array_search($newStatus, $statuses, true);

        if ($newIndex < $currentIndex)
            return back()
                ->withErrors(['message' => 'Статусы нельзя менять в обратном направлении']);

        if ($data['status'] === 'Отгрузка')
            $data['shipped_at'] = now();

        $order->update($data);
        
        return redirect()
            ->route('orders.index')
            ->with('message', 'Статус заказа изменён');
    }

    public function update(OrderRequest $request, Order $order)
    {
        if ($order->status !== 'Новый')
            return back()
                ->withErrors(['Менять можно только новые заказы']);

        $data = $request->validated();

        $data['total_sum'] = $this->syncItems($order, $data['items']);        
        $order->update($data);

        return redirect()
            ->route('orders.index')
            ->with('message', 'Заказ изменён');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        
        return redirect()
            ->route('orders.index')
            ->with('message', 'Заказ удалён (но остаётся в БД)');
    }
}
