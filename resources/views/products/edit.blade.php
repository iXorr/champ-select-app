@extends('layout')
@props(['product'])

@section('content')

<div class="mb-3 d-flex flex-wrap gap-3 justify-content-between">
  <h4 class="mb-0">Редактирование товара | #{{ $product->id }}</h4>

  <a 
    href="{{ route('products.index') }}" 
    class="btn btn-outline-primary" 
  >
    Назад
  </a>
</div>

<form
  method="post"
  action="{{ route('products.update', $product->id) }}"
  enctype="multipart/form-data" 
>
  @csrf
  @method('PUT')

  <div class="row">

    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Наименование</label>

        <input 
          type="text" 
          name="title" 
          class="form-control" 
          value="{{ $product->title }}" 
        />
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Производитель</label>

        <input 
          type="text" 
          name="manufacturer" 
          class="form-control" 
          value="{{ $product->manufacturer }}" 
        />
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Цена</label>

        <input 
          type="number" 
          min="0" 
          name="price" 
          class="form-control" 
          value="{{ $product->price }}" 
        />
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Изображение</label>

        <input 
          type="file" 
          name="image" 
          class="form-control" 
        />
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Единица измерения</label>

        <select class="form-select" name="unit">
          <option 
            value="шт" 
            {{ $product->unit === 'шт' ? 'selected' : null }} 
          >
            шт.
          </option>

          <option 
            value="кг" 
            {{ $product->unit === 'кг' ? 'selected' : null }} 
          >
            кг.
          </option>

          <option 
            value="гр" 
            {{ $product->unit === 'гр' ? 'selected' : null }} 
          >
            гр.
          </option>
          
          <option 
            value="мл" 
            {{ $product->unit === 'мл' ? 'selected' : null }} 
          >
            мл.
          </option>

          <option 
            value="л" 
            {{ $product->unit === 'л' ? 'selected' : null }} 
          >
            л.
          </option>
        </select>
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Короткое описание</label>

        <input 
          type="text" 
          name="short_description" 
          class="form-control" 
          value="{{ $product->short_description }}" 
        />
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Полное описание</label>

        <textarea name="description" class="form-control">
          {{ $product->description }}
        </textarea>
      </div>
    </div>
    
  </div>

  <button type="submit" class="btn btn-primary">Отправить</button>
</form>

<script>
  const $textArea = $('textarea').first();
  $textArea.val($textArea.val().trim());
</script>

@endsection
