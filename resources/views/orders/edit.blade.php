@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Редактировать заказ #{{ $order->id }}</h1>
    <a href="{{ route('orders.show', $order) }}" class="btn btn-link">Назад</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Клиент</label>
                    <select name="client_id" class="form-select" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" @selected(old('client_id', $order->client_id) == $client->id)>{{ $client->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Статус</label>
                    <select name="status" class="form-select">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Дата отгрузки</label>
                    <input type="datetime-local" name="shipped_at" class="form-control"
                           value="{{ old('shipped_at', optional($order->shipped_at)->format('Y-m-d\\TH:i')) }}">
                </div>
            </div>

            <h6 class="mb-2">Позиции</h6>
            @include('orders._items', ['order' => $order])

            <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
        </form>
    </div>
</div>
@endsection
