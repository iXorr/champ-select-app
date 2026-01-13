@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h4 mb-0">{{ $client->full_name }}</h1>
        <div class="text-muted">Клиент</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('clients.index') }}" class="btn btn-link btn-sm">Назад</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Email</dt>
                    <dd class="col-sm-8">{{ $client->email }}</dd>

                    <dt class="col-sm-4 text-muted">Телефон</dt>
                    <dd class="col-sm-8">{{ $client->phone }}</dd>

                    <dt class="col-sm-4 text-muted">Адрес</dt>
                    <dd class="col-sm-8">{{ $client->address }}</dd>

                    <dt class="col-sm-4 text-muted">Заметка</dt>
                    <dd class="col-sm-8">{{ $client->note ?? '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white fw-semibold">Заказы клиента</div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Статус</th>
                        <th class="text-end">Сумма</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($client->orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->status }}</td>
                            <td class="text-end">{{ number_format($order->total_sum, 0, ',', ' ') }} ₽</td>
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary btn-sm">Открыть</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Заказов нет</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
