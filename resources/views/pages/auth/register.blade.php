@extends('layouts.app')

@section('title', 'Регистрация — Мир цветов')

@section('content')
    <section class="form-card">
        <h1>Регистрация клиента</h1>
        <p>Создайте учетную запись, чтобы оформлять доставки и управлять заказами.</p>
        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf
            <div class="form-grid">
                <label>
                    <span>Уникальный логин</span>
                    <input type="text" name="login" value="{{ old('login') }}" required>
                    @error('login')<small>{{ $message }}</small>@enderror
                </label>
                <label>
                    <span>Пароль (мин. 6 символов)</span>
                    <input type="password" name="password" required minlength="6">
                    @error('password')<small>{{ $message }}</small>@enderror
                </label>
                <label>
                    <span>Повторите пароль</span>
                    <input type="password" name="password_confirmation" required minlength="6">
                </label>
                <label class="wide">
                    <span>ФИО</span>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required placeholder="Иванова Анна Сергеевна">
                    @error('full_name')<small>{{ $message }}</small>@enderror
                </label>
                <label>
                    <span>Телефон</span>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="+7(999)-123-45-67">
                    @error('phone')<small>{{ $message }}</small>@enderror
                </label>
                <label>
                    <span>E-mail</span>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<small>{{ $message }}</small>@enderror
                </label>
            </div>
            <button class="btn btn-primary w-100" type="submit">Зарегистрироваться</button>
            <p class="mt-2">Уже с нами? <a href="{{ route('login') }}">Авторизуйтесь</a>.</p>
        </form>
    </section>
@endsection
