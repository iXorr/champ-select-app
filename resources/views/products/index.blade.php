@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Товары</h1>
    <div class="d-flex gap-2">
        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
            @csrf
            <input type="file" name="file" class="form-control form-control-sm" required>
            <button class="btn btn-outline-secondary btn-sm" type="submit">Импорт CSV</button>
        </form>
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Добавить
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th></th>
                <th>Название</th>
                <th>Производитель</th>
                <th>Характеристики</th>
                <th class="text-end">Цена</th>
                <th class="text-end">Заказы</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                @php
                    $image = $product->image_path
                        ? Storage::url($product->image_path)
                        : 'https://via.placeholder.com/60x60?text=No+Image';
                    $features = optional($product->features->first());
                @endphp
                <tr>
                    <td style="width:72px">
                        <img src="{{ $image }}" alt="" class="rounded" width="60" height="60" style="object-fit: cover;">
                    </td>
                    <td class="fw-semibold">{{ $product->title }}</td>
                    <td>{{ $product->manufacturer }}</td>
                    <td class="text-muted small">
                        @if($features)
                            @if($features->roast_level) Обжарка: {{ $features->roast_level }}<br> @endif
                            @if($features->country) Страна: {{ $features->country }} @endif
                        @else
                            —
                        @endif
                    </td>
                    <td class="text-end">{{ number_format($product->price, 0, ',', ' ') }} ₽ / {{ $product->unit }}</td>
                    <td class="text-end">{{ $product->order_items_count ?? 0 }}</td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary">Открыть</a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary">Редактировать</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить товар?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" type="submit">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Список пуст</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
