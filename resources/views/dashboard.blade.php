@extends('layout')

@section('content')

<div class="mb-4">
  <h4>Статистика за последние 3 дня</h4>
</div>

<div class="row mb-4">
  <div class="col-md-6 col-lg-3">
    <div class="card text-bg-primary">
      <div class="card-body">
        <h6 class="card-title">Всего заказов</h6>
        <h3 class="mb-0">{{ $totalOrders }}</h3>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-3">
    <div class="card text-bg-success">
      <div class="card-body">
        <h6 class="card-title">Общая сумма</h6>
        <h3 class="mb-0">{{ number_format($totalSum, 0, '.', ' ') }} рублей</h3>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>Пользователь</th>
          <th>Кол-во заказов</th>
          <th>Сумма</th>
        </tr>
      </thead>
      <tbody>
        @forelse($ordersByUser as $row)
          <tr>
            <td>{{ $row->user->full_name }}</td>
            <td>{{ $row->orders_count }}</td>
            <td>
              {{ number_format($sumByUser[$row->user_id]->total_sum ?? 0, 0, '.', ' ') }} рублей
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="text-center text-muted">
              Нет данных
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
