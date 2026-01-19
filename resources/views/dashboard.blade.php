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
        <h3 class="mb-0">{{ 'here' }}</h3>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-3">
    <div class="card text-bg-success">
      <div class="card-body">
        <h6 class="card-title">Общая сумма</h6>
        <h3 class="mb-0">{{ 'here' }} рублей</h3>
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
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

@endsection
