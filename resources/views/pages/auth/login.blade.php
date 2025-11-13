@extends('layouts.app')

@section('title', 'Вход — Мир цветов')

@section('content')
    <section class="form-card">
        <h1>Авторизация</h1>
        <p>Введите логин и пароль, указанные при регистрации. Администратор: admin / password.</p>
        <form action="{{ route('login') }}" method="POST" novalidate>
            @csrf
            <label>
                <span>Логин</span>
                <input type="text" name="login" value="{{ old('login') }}" required autofocus>
                @error('login')<small>{{ $message }}</small>@enderror
            </label>
            <label>
                <span>Пароль</span>
                <input type="password" name="password" required>
            </label>
            <label class="checkbox">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>Запомнить меня</span>
            </label>
            <button class="btn btn-primary w-100" type="submit">Войти</button>
        </form>
        <p class="mt-2">Нет аккаунта? <a href="{{ route('register') }}">Зарегистрируйтесь</a>.</p>
    </section>
@endsection
