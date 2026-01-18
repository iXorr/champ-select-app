@extends('layout')

@section('content')

<div class="mb-3 d-flex flex-wrap gap-3 justify-content-between">
  <h4 class="mb-0">Создание клиента</h4>

  <a 
    href="{{ route('clients.index') }}" 
    class="btn btn-outline-primary" 
  >
    Назад
  </a>
</div>

<form
  method="post"
  action="{{ route('clients.store') }}"
  enctype="multipart/form-data" 
>
  @csrf

  <div class="row">
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">ФИО</label>
    
        <input 
          type="text" 
          name="full_name" 
          class="form-control" 
          value="{{ old('full_name') }}" 
        />
      </div>
    </div>

    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Email</label>
    
        <input 
          type="text" 
          name="email" 
          class="form-control" 
          value="{{ old('email') }}"  
        />
      </div>
    </div>

    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Адрес доставки</label>
    
        <input 
          type="text" 
          name="address" 
          class="form-control" 
          value="{{ old('address') }}"  
        />
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Контактный номер</label>
    
        <input 
          type="text" 
          name="phone" 
          class="form-control" 
          value="{{ old('phone') }}"  
        />
      </div>
    </div>

    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Пометка</label>
    
        <input 
          type="text" 
          name="note" 
          class="form-control" 
          value="{{ old('note') }}"  
        />
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Отправить</button>
</form>

@endsection
