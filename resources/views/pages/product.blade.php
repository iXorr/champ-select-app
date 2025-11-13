@extends('layouts.app')

@section('title', $product->name . ' — Мир цветов')

@section('content')
    <section class="product-detail">
        <div class="gallery" style="background-image: url('{{ $product->image_url }}')"></div>
        <div class="info">
            <p class="eyebrow">{{ $product->category->name }}</p>
            <h1>{{ $product->name }}</h1>
            <p class="lead">{{ $product->description }}</p>
            <dl class="product-specs">
                <div><dt>Страна</dt><dd>{{ $product->supplier_country ?? '—' }}</dd></div>
                <div><dt>Вид товара</dt><dd>{{ $product->product_type ?? '—' }}</dd></div>
                <div><dt>Цвет</dt><dd>{{ $product->color ?? '—' }}</dd></div>
                <div><dt>Наличие</dt><dd>{{ $product->stock }} шт.</dd></div>
            </dl>
            <div class="cta-row">
                <span class="price">{{ $product->formatted_price }}</span>
                @auth
                    <button class="btn btn-primary add-to-cart" data-add-to-cart data-product="{{ $product->id }}" @disabled($product->stock < 1)>
                        Добавить в корзину
                    </button>
                @else
                    <a class="btn btn-outline" href="{{ route('login') }}">Войдите, чтобы заказать</a>
                @endauth
            </div>
        </div>
    </section>

    @if($similarProducts->isNotEmpty())
        <section class="similar">
            <div class="section-header">
                <h2>Похожие товары</h2>
                <a href="{{ route('catalog', ['category' => $product->category->slug]) }}">Смотреть все</a>
            </div>
            <div class="catalog-grid">
                @foreach($similarProducts as $item)
                    <article class="product-card">
                        <div class="product-thumb" style="background-image: url('{{ $item->image_url }}')"></div>
                        <div class="product-body">
                            <h3><a href="{{ route('products.show', $item) }}">{{ $item->name }}</a></h3>
                            <div class="product-bottom">
                                <strong>{{ $item->formatted_price }}</strong>
                                <a class="btn btn-text" href="{{ route('products.show', $item) }}">Подробнее</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection
