@extends('layout')
@props(['user'])

@section('content')

<div class="mb-3 d-flex flex-wrap gap-3 justify-content-between">
  <h4 class="mb-0">Редактирование пользователя | #{{ $user->id }}</h4>

  <a 
    href="{{ route('users.index') }}" 
    class="btn btn-outline-primary" 
  >
    Назад
  </a>
</div>

<form
  method="post"
  action="{{ route('users.update', $user->id) }}"
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
          value="{{ $user->full_name }}" 
        />
      </div>
    </div>

    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Логин</label>
    
        <input 
          type="text" 
          name="login" 
          class="form-control" 
          value="{{ $user->login }}"  
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
          value="{{ $user->email }}"  
        />
      </div>
    </div>

    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Тип аккаунта</label>
    
        <select class="form-select" name="role">
          <option 
            value="manager" 
            {{ $user->role === 'manager' ? 'selected' : null }} 
          >
            Менеджер
          </option>

          <option 
            value="admin" 
            {{ $user->role === 'admin' ? 'selected' : null }} 
          >
            Администратор
          </option>
        </select>
      </div>
    </div>
      
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Пароль</label>
    
        <input 
          type="password" 
          name="password" 
          class="form-control" 
        />
      </div>
    </div>
    
    <div class="col-lg-6">
      <div class="mb-3">
        <label class="form-label">Подтверждение пароля</label>
    
        <input 
          type="password" 
          name="password_confirmation" 
          class="form-control" 
        />
      </div>
    </div>

    <div class="col-lg-6">
      <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
  </div>
</form>

@endsection
