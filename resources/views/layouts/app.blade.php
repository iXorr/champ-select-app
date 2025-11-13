@php
    $user = auth()->user();
@endphp
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Мир цветов')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="{{ $bodyClass ?? '' }}">
<header class="site-header">
    <div class="container header-inner">
        <a href="{{ route('catalog') }}" class="logo">Мир цветов</a>
        <nav class="nav">
            <a href="{{ route('catalog') }}" class="{{ request()->routeIs('catalog') ? 'active' : '' }}">Каталог</a>
            @auth
                <a href="{{ route('cabinet') }}" class="{{ request()->routeIs('cabinet') ? 'active' : '' }}">Личный кабинет</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin*') ? 'active' : '' }}">Админ-панель</a>
                @endif
            @endauth
        </nav>
        <div class="user-block">
            @auth
                <span class="user-name">Привет, {{ \Illuminate\Support\Str::words($user->full_name, 2, '') }}!</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-text">Войти</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
            @endauth
        </div>
        <button class="burger" data-toggle-menu>
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
<div class="mobile-menu" data-mobile-menu>
    <a href="{{ route('catalog') }}">Каталог</a>
    @auth
        <a href="{{ route('cabinet') }}">Личный кабинет</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}">Админ-панель</a>
        @endif
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline w-100">Выйти</button>
        </form>
    @else
        <a href="{{ route('login') }}">Войти</a>
        <a href="{{ route('register') }}">Регистрация</a>
    @endauth
</div>
<main class="content">
    <div class="container">
        @if(session('success'))
            <div class="alert success" data-alert>{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert error" data-alert>
                <strong>Проверьте форму:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>
</main>
<footer class="site-footer">
    <div class="container footer-inner">
        <p>© {{ date('Y') }} «Мир цветов». Вдохновляем людей красотой.</p>
        <div class="footer-links">
            <a href="tel:+79000000000">+7 (900) 000-00-00</a>
            <a href="mailto:hello@flowerworld.ru">hello@flowerworld.ru</a>
        </div>
    </div>
</footer>
@stack('scripts')
</body>
</html>
