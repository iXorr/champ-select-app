@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Новый заказ</h1>
    <a href="{{ route('orders.index') }}" class="btn btn-link">Назад</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Клиент</label>
                    <select name="client_id" class="form-select" required>
                        <option value="">Выберите клиента</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Статус</label>
                    <select name="status" class="form-select">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Дата отгрузки</label>
                    <input type="datetime-local" name="shipped_at" class="form-control" value="{{ old('shipped_at') }}">
                </div>
            </div>

            <h6 class="mb-2">Позиции</h6>
            @include('orders._items')

            <button type="submit" class="btn btn-primary mt-3">Создать</button>
        </form>
    </div>
</div>
@endsection
