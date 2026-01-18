@extends('layout')
@props(['orders', 'users', 'clients'])

@section('content')

<div class="mb-3 d-flex flex-wrap gap-3 justify-content-between">
  <h4 class="mb-0">Заказы</h4>

  <a 
    href="{{ route('orders.create') }}" 
    class="btn btn-primary" 
  >
    Добавить
  </a>
</div>

@if($orders->isNotEmpty())

<form 
  method="post"
  action="/orders/filter"
  enctype="multipart/form-data" 
  class="mb-4" 
  id="filter-form" 
>
  @csrf

  <div class="row">
    <div class="col-lg-2">
      <label class="mb-2">По статусу</label>
 
      <select class="form-select" name="status">
        <option value="" selected></option>
        <option value="Новый">Новый</option>
        <option value="Отгружен">Отгружен</option>
        <option value="Доставка">Доставка</option>
        <option value="Выдан">Выдан</option>
        <option value="Отменен">Отменен</option>
      </select>
    </div>

    <div class="col-lg-2">
      <label class="mb-2">По пользователю</label>

      <select class="form-select" name="user_id">
        <option value="" selected></option>
        @foreach ($users as $user)
          <option value="{{ $user->id }}">{{ $user->full_name }}</option>
        @endforeach
      </select>
    </div>
    
    <div class="col-lg-2">
      <label class="mb-2">По клиенту</label>

      <select class="form-select" name="client_id">
        <option value="" selected></option>
        @foreach ($clients as $client)
          <option value="{{ $client->id }}">{{ $client->full_name }}</option>
        @endforeach
      </select>
    </div>
    
    <div class="col-lg-2">
      <label class="mb-2">По дате создания</label>

      <input 
        class="form-control" 
        type="date" 
        name="created_at" 
      />
    </div>
    
    <div class="col-lg-2">
      <label class="mb-2">По дате отгрузки</label>

      <input 
        class="form-control" 
        type="date" 
        name="shipped_at" 
      />
    </div>
  </div>
</form>

<div id="orders-table-wrapper">
  @include('orders.partials.table', ['orders' => $orders])
</div>

@else

<div class="alert alert-warning" role="alert">
  Список пуст
</div>

@endif

<script>
  $(function() {
    $(document).on('change', '.update-status-form', function() {
      $(this).submit()
    })

    const $filterForm = $('#filter-form')
    const $wrapper = $('#orders-table-wrapper')

    let xhr = null

    $filterForm.on('change', 'select, input', function() {
      xhr = $.ajax({
        url: $filterForm.attr('action'),
        method: 'POST',
        data: $filterForm.serialize(),

        beforeSend() {
          $wrapper.fadeTo(200, 1)
        },

        success(html) {
          $wrapper.fadeOut(200, function() {
            $wrapper.html(html).fadeIn(200)
          })
        },

        error() {
          alert('Ошибка загрузки')
        }
      })
    })
  })
</script>

@endsection
