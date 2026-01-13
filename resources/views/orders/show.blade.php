@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h4 mb-0">Заказ #{{ $order->id }}</h1>
        <div class="text-muted">Статус: {{ $order->status }}</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Отменить заказ?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger btn-sm" type="submit">Отменить</button>
        </form>
        <a href="{{ route('orders.index') }}" class="btn btn-link btn-sm">Назад</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white fw-semibold">Информация</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Клиент</dt>
                    <dd class="col-7">{{ $order->client->full_name ?? '—' }}</dd>

                    <dt class="col-5 text-muted">Менеджер</dt>
                    <dd class="col-7">{{ $order->user->full_name ?? '—' }}</dd>

                    <dt class="col-5 text-muted">Создан</dt>
                    <dd class="col-7">{{ optional($order->created_at)->format('d.m.Y H:i') }}</dd>

                    <dt class="col-5 text-muted">Отгрузка</dt>
                    <dd class="col-7">{{ optional($order->shipped_at)->format('d.m.Y H:i') ?? '—' }}</dd>

                    <dt class="col-5 text-muted">Сумма</dt>
                    <dd class="col-7 fw-semibold">{{ number_format($order->total_sum, 0, ',', ' ') }} ₽</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">Позиции</div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Товар</th>
                        <th class="text-end">Кол-во</th>
                        <th class="text-end">Скидка</th>
                        <th class="text-end">Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($order->items as $item)
                        <tr>
                            <td>{{ $item->product->title ?? '—' }}</td>
                            <td class="text-end">{{ $item->quantity }}</td>
                            <td class="text-end">{{ $item->discount }}%</td>
                            <td class="text-end">{{ number_format($item->sum, 0, ',', ' ') }} ₽</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Нет позиций</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
