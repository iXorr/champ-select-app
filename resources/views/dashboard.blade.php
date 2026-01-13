@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Дашборд (последние 3 дня)</h1>
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small">Всего заказов</div>
                <div class="display-6 fw-semibold">{{ $total_orders }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small">Сумма</div>
                <div class="display-6 fw-semibold">{{ number_format($total_sum, 0, ',', ' ') }} ₽</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small">Период</div>
                <div class="fw-semibold">{{ $from->format('d.m.Y H:i') }} – сейчас</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-semibold">
        Статистика по пользователям
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
            <tr>
                <th>Имя</th>
                <th>Логин</th>
                <th>Роль</th>
                <th class="text-end">Заказы</th>
                <th class="text-end">Сумма</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->full_name }}</td>
                    <td class="text-muted">{{ $user->login }}</td>
                    <td class="text-uppercase">{{ $user->role }}</td>
                    <td class="text-end">{{ $user->orders_count ?? 0 }}</td>
                    <td class="text-end">{{ number_format($user->orders_sum ?? 0, 0, ',', ' ') }} ₽</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Данных нет</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
