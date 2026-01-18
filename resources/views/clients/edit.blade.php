@extends('layout')
@props(['client'])

@section('content')

<div class="mb-3 d-flex flex-wrap gap-3 justify-content-between">
  <h4 class="mb-0">Редактирование клиента | #{{ $client->id }}</h4>

  <a 
    href="{{ route('clients.index') }}" 
    class="btn btn-outline-primary" 
  >
    Назад
  </a>
</div>

<form
  method="post"
  action="{{ route('clients.update', $client->id) }}"
  enctype="multipart/form-data" 
>
  @csrf
  @method('PUT')

  <div class="row">
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">ФИО</label>
    
        <input 
          type="text" 
          name="full_name" 
          class="form-control" 
          value="{{ $client->full_name }}" 
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
          value="{{ $client->email }}"  
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
          value="{{ $client->address }}"  
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
          value="{{ $client->phone }}"  
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
          value="{{ $client->note }}"  
        />
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Отправить</button>
</form>

@endsection
