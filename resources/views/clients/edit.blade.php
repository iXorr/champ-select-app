@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Редактировать клиента</h1>
    <a href="{{ route('clients.index') }}" class="btn btn-link">Назад</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('clients.update', $client) }}" method="POST">
            @csrf
            @method('PUT')
            @include('clients._form', ['client' => $client])
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
</div>
@endsection
