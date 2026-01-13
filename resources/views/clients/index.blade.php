@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Клиенты</h1>
    <div class="d-flex gap-2">
        <form action="{{ route('clients.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
            @csrf
            <input type="file" name="file" class="form-control form-control-sm" required>
            <button class="btn btn-outline-secondary btn-sm" type="submit">Импорт CSV</button>
        </form>
        <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Добавить
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>Имя</th>
                <th>Email</th>
                <th>Телефон</th>
                <th class="text-end">Заказы</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($clients as $client)
                <tr>
                    <td class="fw-semibold">{{ $client->full_name }}</td>
                    <td class="text-muted">{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td class="text-end">{{ $client->orders_count ?? 0 }}</td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('clients.show', $client) }}" class="btn btn-outline-secondary">Открыть</a>
                            <a href="{{ route('clients.edit', $client) }}" class="btn btn-outline-primary">Редактировать</a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Удалить клиента?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" type="submit">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Список пуст</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
