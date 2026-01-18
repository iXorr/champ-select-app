@extends('layout')

@section('content')

<div class="mb-3 d-flex flex-wrap gap-3 justify-content-between">
  <h4 class="mb-0">Создание товара</h4>

  <a 
    href="{{ route('products.index') }}" 
    class="btn btn-outline-primary" 
  >
    Назад
  </a>
</div>

<form
  method="post"
  action="{{ route('products.store') }}"
  enctype="multipart/form-data" 
>
  @csrf

  <div class="row">

    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Наименование</label>

        <input 
          type="text" 
          name="title" 
          class="form-control" 
          value="{{ old('title') }}" 
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
          value="{{ old('manufacturer') }}" 
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
          value="{{ old('price') }}" 
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
          >
            шт.
          </option>

          <option 
            value="кг" 
          >
            кг.
          </option>

          <option 
            value="гр" 
          >
            гр.
          </option>
          
          <option 
            value="мл" 
          >
            мл.
          </option>

          <option 
            value="л" 
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
          value="{{ old('short_description') }}" 
        />
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Полное описание</label>

        <textarea name="description" class="form-control">
          {{ old('description') }}
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
