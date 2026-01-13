@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Редактировать пользователя</h1>
    <a href="{{ route('users.index') }}" class="btn btn-link">Назад</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            @include('users._form', ['user' => $user])
            <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
        </form>
    </div>
</div>
@endsection
