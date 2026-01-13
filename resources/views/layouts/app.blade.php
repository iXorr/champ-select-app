<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CRM' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">Coffee CRM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            @auth
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Дашборд</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Заказы</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('clients.index') }}">Клиенты</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Товары</a></li>
                    @can('admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Пользователи</a></li>
                    @endcan
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-white-50 small">
                        {{ auth()->user()->full_name }}<br>
                        <span class="text-uppercase">{{ auth()->user()->role }}</span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            Профиль
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Мой профиль</a></li>
                            <li><a class="dropdown-item" href="{{ route('account.password.edit') }}">Сменить пароль</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Выход</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth
        </div>
    </div>
    @guest
        <div class="container d-lg-none text-end py-2">
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Войти</a>
        </div>
    @endguest
</nav>

<main class="container py-4">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->has('general'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ $errors->first('general') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-2">Проверьте форму:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
