@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Редактировать товар</h1>
    <a href="{{ route('products.index') }}" class="btn btn-link">Назад</a>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('products._form', ['product' => $product])
            <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
        </form>
    </div>
</div>
@endsection
