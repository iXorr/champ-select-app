@extends('layout')

@section('content')

<h4 class="mb-3">
  Авторизация
</h4>

<form
  method="post"
  action="/login"
  enctype="multipart/form-data"
>
  @csrf

  <div class="row">
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
        <label class="form-label">Пароль</label>
    
        <input 
          type="password" 
          name="password" 
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
