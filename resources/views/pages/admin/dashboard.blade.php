@extends('layouts.app')

@section('title', 'Админ-панель — Мир цветов')

@section('content')
    @php
        $statusLabels = [
            'new' => 'Новый',
            'in_progress' => 'В работе',
            'done' => 'Выполнен',
            'canceled' => 'Отменен',
        ];
    @endphp
    <section class="admin-dashboard">
        <h1>Панель администратора</h1>
        <p class="lead">Управляйте заказами и следите за ключевыми показателями магазина.</p>

        <div class="stats-grid">
            <div class="stat">
                <span>Всего заказов</span>
                <strong>{{ $stats['totalOrders'] }}</strong>
            </div>
            <div class="stat">
                <span>Новые</span>
                <strong>{{ $stats['newOrders'] }}</strong>
            </div>
            <div class="stat">
                <span>В работе</span>
                <strong>{{ $stats['inProgress'] }}</strong>
            </div>
            <div class="stat">
                <span>Выполнено</span>
                <strong>{{ $stats['doneOrders'] }}</strong>
            </div>
            <div class="stat">
                <span>Товаров в каталоге</span>
                <strong>{{ $stats['products'] }}</strong>
            </div>
            <div class="stat">
                <span>Клиентов</span>
                <strong>{{ $stats['clients'] }}</strong>
            </div>
        </div>

        <section class="card">
            <div class="section-header">
                <h2>Последние заказы</h2>
                <a href="{{ route('admin.orders.index') }}">Перейти ко всем</a>
            </div>
            <table class="orders-table">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Клиент</th>
                    <th>Контакты</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                @foreach($latestOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->contact_name }}</td>
                        <td>
                            {{ $order->contact_phone }}<br>
                            {{ $order->contact_email }}
                        </td>
                        <td>{{ $order->formatted_total }}</td>
                        <td><span class="status status-{{ $order->status }}">{{ $statusLabels[$order->status] }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </section>
@endsection
