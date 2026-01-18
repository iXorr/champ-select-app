@extends('layout')

@section('content')

<h4 class="mb-3">
  Создание пользователя
</h4>

<form
  method="post"
  action="{{ route('users.store') }}"
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
        <label class="form-label">Логин</label>
    
        <input 
          type="text" 
          name="login" 
          class="form-control" 
          value="{{ old('login') }}"  
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
        <label class="form-label">Тип аккаунта</label>
    
        <select class="form-select" name="role">
          <option 
            value="manager" 
          >
            Менеджер
          </option>

          <option 
            value="admin" 
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
          value="{{ old('password') }}"  
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
          value="{{ old('password_confirmation') }}"  
        />
      </div>
    </div>

    <div class="col-lg-6">
      <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
  </div>
</form>

@endsection
