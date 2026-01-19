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
  
  <div class="d-flex align-items-center gap-3 mb-3">
    <button
      class="btn btn-outline-secondary"
      id="add-feature-btn"  
    >
      Добавить доп. характеристику
    </button>
    
    <button type="submit" class="btn btn-primary">Отправить</button>
  </div>

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

  <div class="row mb-4 mt-4 feature">
    <div class="col-lg-3">
      <label class="form-label">Название характеристики</label>

      <input 
        type="text" 
        name="features[0][title]" 
        class="form-control" 
      />
    </div>

    <div class="col-lg-3">
      <label class="form-label">Значение характеристики</label>

      <input 
        type="text" 
        name="features[0][value]" 
        class="form-control" 
      />
    </div>

    
    <div class="col-lg-3 d-flex align-items-end">
      <button class="btn btn-outline-danger delete-feature-btn">
        Удалить
      </button>
    </div>
  </div>
</form>

<script>
  const $container = $('form')

  $container.on('submit', function(e) {
    e.preventDefault()
    reindexFeatures()

    this.submit()
  })

  $(document).on('click', '#add-feature-btn', function(e) {
    e.preventDefault()

    const $clone = $('.feature').first().clone(true)
    $clone.hide()

    $clone.find('input').each(function() {
      this.value = null
    })

    $container.append($clone)
    $clone.slideDown(300)

    reindexFeatures()
  })

  $(document).on('click', '.delete-feature-btn', function(e) {
    e.preventDefault()

    const $allFeatures = $(document).find('.feature')
    if ($allFeatures.length < 2)
      return;

    const $feature = $(this).closest('.feature')

    $feature.slideUp(300, function() {
      $(this).remove()
      reindexFeatures()
    })
  })

  function reindexFeatures() {
    $('.feature').each(function(index, card) {
      $(this).find('input').each(function() {
        this.name = this.name.replace(/\[\d+\]/, `[${index}]`)
      })
    })
  }

  const $textArea = $('textarea').first();
  $textArea.val($textArea.val().trim());
</script>

@endsection
