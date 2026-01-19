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
  id="filter-orders-form" 
  class="mb-4"
>
  @csrf

  <div class="row">
    <div class="col-lg-2">
      <label class="mb-2">По статусу</label>

      <select class="form-select" name="status">
        <option value=""></option>
        <option value="Новый">Новый</option>
        <option value="Отгрузка">Отгрузка</option>
        <option value="Доставка">Доставка</option>
        <option value="Выдан">Выдан</option>
        <option value="Отменен">Отменен</option>
      </select>
    </div>

    <div class="col-lg-2">
      <label class="mb-2">По пользователю</label>

      <select class="form-select" name="user_id">
        <option value=""></option>
        @foreach ($users as $user)
          <option value="{{ $user->id }}">{{ $user->full_name }}</option>
        @endforeach
      </select>
    </div>
    
    <div class="col-lg-2">
      <label class="mb-2">По клиенту</label>

      <select class="form-select" name="client_id">
        <option value=""></option>
        @foreach ($clients as $client)
          <option value="{{ $client->id }}">{{ $client->full_name }}</option>
        @endforeach
      </select>
    </div>
    
    <div class="col-lg-2">
      <label class="mb-2">По дате создания</label>

      <input type="date" name="created_at" class="form-control" />
    </div>
    
    <div class="col-lg-2">
      <label class="mb-2">По дате отгрузки</label>

      <input type="date" name="shipped_at" class="form-control" />
    </div>
  </div>
</form>

<div id="list-wrapper">
  @include('orders.partials.list')
</div>

<script>
  $(function() {
    $(document).on('change', '.update-status-form', function() {
      $(this).submit()
    })

    const $filterForm = $('#filter-orders-form')
    const $listWrapper = $('#list-wrapper')

    $filterForm.on('change', function() {
      let xhr = null

      xhr = $.ajax({
        url: $filterForm.attr('action'),
        method: 'post',
        data: $filterForm.serialize(),

        success(response) {
          $listWrapper.fadeOut(200, function() {
            $(this).html(response).fadeIn(200)
          })
        },
        
        error() {
          alert('Что-то пошло не так')
        }
      })
    })
  })
</script>

@else

<div class="alert alert-warning" role="alert">
  Список пуст
</div>

@endif

@endsection
