@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h1 class="h5 mb-3">Мой профиль</h1>
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Имя</dt>
                    <dd class="col-sm-8">{{ $user->full_name }}</dd>

                    <dt class="col-sm-4 text-muted">Логин</dt>
                    <dd class="col-sm-8">{{ $user->login }}</dd>

                    <dt class="col-sm-4 text-muted">Email</dt>
                    <dd class="col-sm-8">{{ $user->email }}</dd>

                    <dt class="col-sm-4 text-muted">Роль</dt>
                    <dd class="col-sm-8 text-uppercase">{{ $user->role }}</dd>
                </dl>
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('account.password.edit') }}" class="btn btn-outline-primary btn-sm">
                        Сменить пароль
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm" type="submit">Выйти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
