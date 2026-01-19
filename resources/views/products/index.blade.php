@extends('layout')
@props(['products'])

@section('content')

<div class="mb-4 d-flex flex-wrap gap-3 justify-content-between">
  <div class="d-flex gap-4 align-items-center">
    <h4 class="mb-0">Товары</h4>

    <form
      method="post"
      action="/products/import"
      enctype="multipart/form-data" 
    >
      @csrf

      <div class="row g-3">
        <div class="col-lg-8">
          <input 
            type="file" 
            name="file" 
            class="form-control" 
          />
        </div>

        <div class="col-lg-4">
          <button 
            type="submit" 
            class="btn btn-outline-primary" 
          >
            Импорт CSV
          </button>
        </div>
      </div>
    </form>
  </div>

  <a 
    href="{{ route('products.create') }}" 
    class="btn btn-primary" 
  >
    Добавить
  </a>
</div>

@if($products->isNotEmpty())

<div class="row g-3">
  @foreach($products as $product)

  <div class="col-xl-3 col-lg-4 col-md-6">
    <div class="card">
      <img 
        src="{{ $product->image_path 
                  ? '/storage/' . $product->image_path 
                  : asset('images/placeholder.jpg') }}" 
        class="card-img-top" 
        style="height: 14rem;"
        alt="Image" 
      />

      <div class="card-body">
        <h5 class="card-title">{{ $product->title }}</h5>

        <p class="card-text text-truncate mb-1">
          <span class="text-muted">Производитель:</span>
          <span>{{ $product->manufacturer }}</span>
        </p>
        
        <p class="card-text text-truncate mb-1">
          <span class="text-muted">Единица измерения:</span>
          <span>{{ $product->unit }}</span>
        </p>
        
        <p class="card-text text-truncate mb-1">
          <span class="text-muted">Стоимость:</span>
          <span>{{ $product->price }}</span>
        </p>
        
        <p class="card-text text-truncate">
          <span class="text-muted">Короткое описание:</span>
          <span>{{ $product->short_description }}</span>
        </p>

        @if($product->features->isNotEmpty())
          @foreach($product->features as $feature)
            <p class="card-text text-truncate">
              <span class="text-muted">{{ $feature->title }}:</span>
              <span>{{ $feature->value }}</span>
            </p> 
          @endforeach
        @endif

        <div class="d-flex gap-2 mt-2">
          <a 
            href="{{ route('products.edit', $product->id) }}" 
            class="btn btn-outline-secondary" 
          >
            Изменить
          </a>

          <form
            method="post"
            action="{{ route('products.destroy', $product->id) }}"
            enctype="multipart/form-data"
          >
            @csrf
            @method('DELETE')

            <button 
              type="submit" 
              class="btn btn-outline-danger" 
            >
              Удалить
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>  
  
  @endforeach
</div>

@else

<div class="alert alert-warning" role="alert">
  Список пуст
</div>

@endif

@endsection
