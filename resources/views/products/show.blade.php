@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h4 mb-0">{{ $product->title }}</h1>
        <div class="text-muted">Товар</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary btn-sm">Редактировать</a>
        <a href="{{ route('products.index') }}" class="btn btn-link btn-sm">Назад</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        @php
            $image = $product->image_path
                ? Storage::url($product->image_path)
                : 'https://via.placeholder.com/400x260?text=No+Image';
            $features = optional($product->features->first());
        @endphp
        <div class="card shadow-sm border-0 h-100">
            <img src="{{ $image }}" class="card-img-top" style="object-fit: cover; height: 240px;" alt="">
            <div class="card-body">
                <div class="fw-semibold mb-2">{{ number_format($product->price, 0, ',', ' ') }} ₽ / {{ $product->unit }}</div>
                <div class="text-muted small">Производитель</div>
                <div class="mb-2">{{ $product->manufacturer }}</div>
                <div class="text-muted small">Кратко</div>
                <div class="mb-2">{{ $product->short_description }}</div>
                <div class="text-muted small">Характеристики</div>
                <div>
                    @if($features)
                        @if($features->roast_level) Обжарка: {{ $features->roast_level }}<br>@endif
                        @if($features->country) Страна: {{ $features->country }}@endif
                    @else
                        —
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white fw-semibold">Описание</div>
            <div class="card-body">
                <p class="mb-0">{{ $product->description }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
