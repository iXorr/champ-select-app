@extends('layout')
@props(['user'])

@section('content')

<div class="row justify-content-center">
  <div class="col-lg-5">    
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Личные данные</h5>

        <div class="card-text text-truncate">
          <span>ФИО:</span>
          <span>{{ $user->full_name }}</span>
        </div>
        
        <div class="card-text text-truncate">
          <span>Email:</span>
          <span>{{ $user->email }}</span>
        </div>
        
        <div class="card-text text-truncate">
          <span>Логин:</span>
          <span>{{ $user->login }}</span>
        </div>
        
        <div class="card-text text-truncate">
          <span>Тип аккаунта:</span>
          <span>
            {{ $user->role === 'admin' ? 'Администратор' : 'Менеджер' }}
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-5">    
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-3">Смена пароля</h5>

        <form
          method="post"
          action="/change-password"
          enctype="multipart/form-data"
        >
          @csrf

          <div class="mb-3">
            <label class="form-label">Текущий пароль</label>
        
            <input 
              type="password" 
              name="current_password" 
              class="form-control"
            />
          </div>
          
          <div class="mb-3">
            <label class="form-label">Старый пароль</label>
        
            <input 
              type="password" 
              name="new_password" 
              class="form-control"
            />
          </div>
          
          <div class="mb-3">
            <label class="form-label">Подтвердите старый пароль</label>
        
            <input 
              type="password" 
              name="new_password_confirmation" 
              class="form-control"
            />
          </div>

          <button 
            type="submit" 
            class="btn btn-primary"
          >
            Отправить
          </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection
