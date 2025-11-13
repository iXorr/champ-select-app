@extends('layouts.app')

@section('title', 'Управление заказами — Мир цветов')

@section('content')
    @php
        $statusLabels = [
            'new' => 'Новый',
            'in_progress' => 'В работе',
            'done' => 'Выполнен',
            'canceled' => 'Отменен',
        ];
    @endphp
    <section class="admin-orders">
        <div class="section-header">
            <h1>Все заказы</h1>
            <form method="GET" class="filters-form">
                <label>
                    <span>Статус</span>
                    <select name="status" onchange="this.form.submit()">
                        <option value="">Все</option>
                        @foreach($statusLabels as $key => $label)
                            <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
            </form>
        </div>

        @foreach($orders as $order)
            <article class="order-admin-card">
                <header>
                    <div>
                        <strong>Заказ №{{ $order->id }}</strong>
                        <span class="muted">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <span class="status status-{{ $order->status }}">{{ $statusLabels[$order->status] }}</span>
                </header>
                <div class="order-grid">
                    <div>
                        <h4>Клиент</h4>
                        <p>{{ $order->contact_name }}</p>
                        <p>{{ $order->contact_phone }}<br>{{ $order->contact_email }}</p>
                    </div>
                    <div>
                        <h4>Доставка</h4>
                        <p>{{ $order->address }}</p>
                        <p>Дата: {{ $order->preferred_date->format('d.m.Y') }}<br>Время: {{ $order->preferred_time_formatted }}</p>
                    </div>
                    <div>
                        <h4>Содержимое</h4>
                        <ul>
                            @foreach($order->items as $item)
                                <li>{{ $item->product->name }} × {{ $item->quantity }}</li>
                            @endforeach
                        </ul>
                        <p>Сумма: {{ $order->formatted_total }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="order-status-form">
                    @csrf
                    <label>
                        <span>Статус</span>
                        <select name="status" required>
                            @foreach($statusLabels as $key => $label)
                                <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="wide">
                        <span>Причина отмены (если требуется)</span>
                        <textarea name="cancellation_reason" rows="2">{{ old('cancellation_reason', $order->cancellation_reason) }}</textarea>
                    </label>
                    <button class="btn btn-primary" type="submit">Обновить</button>
                </form>
            </article>
        @endforeach

        {{ $orders->links() }}
    </section>
@endsection
