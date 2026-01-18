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
    public function index()
    {
        return view('orders.index', [
            'orders' => Order::all(),
            'users' => User::all(),
            'clients' => Client::all()
        ]);
    }

    public function create()
    {
        return view('orders.create', [
            'clients' => Client::all(),
            'products' => Product::all()
        ]);
    }

    private function syncItems(Order $order, array $items)
    {
        $order->items()->delete();

        $totalSum = 0;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            $sum = $item['quantity'] * $product->id;
            $calcSum = $sum - ($sum / 100 * $item['discount']);

            $totalSum += $calcSum;

            OrderItem::create([
                ...$item,
                'order_id' => $order->id,
                'sum' => $calcSum
            ]);
        }

        return $totalSum;
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
        return view('orders.edit', [
            'order' => $order
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

        $order->update($data);
        
        return redirect()
            ->route('orders.index')
            ->with('message', 'Статус заказа изменён');
    }

    public function update(OrderRequest $request, Order $order)
    {
        // $data = $request->validated();

        // $order->update($data);

        // return redirect()
        //     ->route('orders.index')
        //     ->with('message', 'Заказ изменён');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        
        return redirect()
            ->route('orders.index')
            ->with('message', 'Заказ удалён');
    }
}
