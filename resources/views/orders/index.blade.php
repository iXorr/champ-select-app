@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Заказы</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Новый заказ
    </a>
</div>

<form class="card shadow-sm border-0 mb-3" method="GET">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Статус</label>
                <select name="status" class="form-select">
                    <option value="">Все</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            @can('admin')
                <div class="col-md-3">
                    <label class="form-label">Менеджер</label>
                    <select name="user_id" class="form-select">
                        <option value="">Все</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected($filters['user_id'] == $user->id)>{{ $user->full_name }}</option>
                        @endforeach
                    </select>
                </div>
            @endcan
            <div class="col-md-3">
                <label class="form-label">Клиент</label>
                <select name="client_id" class="form-select">
                    <option value="">Все</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" @selected($filters['client_id'] == $client->id)>{{ $client->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Дата создания</label>
                <div class="input-group">
                    <input type="date" name="created_from" class="form-control" value="{{ $filters['created_from'] }}">
                    <input type="date" name="created_to" class="form-control" value="{{ $filters['created_to'] }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Дата отгрузки</label>
                <div class="input-group">
                    <input type="date" name="shipped_from" class="form-control" value="{{ $filters['shipped_from'] }}">
                    <input type="date" name="shipped_to" class="form-control" value="{{ $filters['shipped_to'] }}">
                </div>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm" type="submit">Фильтровать</button>
            <a href="{{ route('orders.index') }}" class="btn btn-link btn-sm">Сбросить</a>
        </div>
    </div>
</form>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Клиент</th>
                <th>Менеджер</th>
                <th>Статус</th>
                <th class="text-end">Сумма</th>
                <th class="text-muted">Создан</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->client->full_name ?? '—' }}</td>
                    <td>{{ $order->user->full_name ?? '—' }}</td>
                    <td>{{ $order->status }}</td>
                    <td class="text-end">{{ number_format($order->total_sum, 0, ',', ' ') }} ₽</td>
                    <td class="text-muted">{{ optional($order->created_at)->format('d.m.Y H:i') }}</td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">Открыть</a>
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-primary">Редактировать</a>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Отменить заказ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" type="submit">Отменить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Заказов нет</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
