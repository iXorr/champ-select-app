@extends('layout')
@props(['clients', 'products', 'order'])

@section('content')

<div class="mb-3 d-flex flex-wrap gap-3 justify-content-between">
  <h4 class="mb-0">Редактирование заказа | #{{ $order->id }}</h4>

  <a 
    href="{{ route('orders.index') }}" 
    class="btn btn-outline-primary" 
  >
    Назад
  </a>
</div>

@if ($clients->isNotEmpty() && $products->isNotEmpty())

<form
  method="post"
  action="{{ route('orders.store') }}"
  enctype="multipart/form-data" 
>
  @csrf

  <div class="mb-4 d-flex flex-wrap gap-3 justify-content-between">
    <div class="d-flex gap-2 align-items-center">
      <label class="form-label mb-0">Клиент</label>

      <select class="form-select" name="client_id">

      @foreach ($clients as $client)
        <option value="{{ $client->id }}">{{ $client->full_name }}</option>
      @endforeach

      </select>
    </div>

    <div class="d-flex gap-3">
      <button 
        class="btn btn-outline-secondary" 
        id="add-item-btn"
      >
        Добавить позицию
      </button>
      
      <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <div class="row">    
        <div class="col-lg-3">
          <div class="mb-3">
            <label class="form-label">Товар</label>

            <select class="form-select" name="items[0][product_id]">

            @foreach ($products as $product)
              <option value="{{ $product->id }}">{{ $product->title }}</option>
            @endforeach

            </select>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="mb-3">
            <label class="form-label">Количество</label>
    
            <input 
              type="number" 
              min="1" 
              name="items[0][quantity]" 
              class="form-control" 
            />
          </div>
        </div>
        
        <div class="col-lg-3">
          <div class="mb-3">
            <label class="form-label">Скидка (в процентах)</label>
    
            <input 
              type="number" 
              min="0" 
              max="100" 
              name="items[0][discount]" 
              class="form-control" 
            />
          </div>
        </div>
                
        <div class="col-lg-3 d-flex align-items-end">
          <div class="mb-3">
            <button class="btn btn-outline-danger delete-item-btn">
              Удалить
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

@else

<div class="alert alert-warning" role="alert">
  Нет или клиентов, или товаров
</div>
  
@endif

<script>
  const $container = $('form')

  $container.on('click', '#add-item-btn', function(e) {
    e.preventDefault()

    const $clone = $('.card').first().clone(true)
    $clone.hide()

    $clone.find('input, select').each(function() {
      this.value = null
    })

    $container.append($clone)
    $clone.slideDown(300)

    reindexCards()
  })

  $container.on('click', '.delete-item-btn', function(e) {
    e.preventDefault()

    const $card = $(this).closest('.card')

    $card.slideUp(300, function() {
      $(this).remove()
      reindexCards()
    })
  })

  function reindexCards() {
    $('.card').each(function(index, card) {
      $(this).find('input, select').each(function() {
        this.name = this.name.replace(/\[\d+\]/, `[${index}]`)
      })
    })
  }
</script>

@endsection
