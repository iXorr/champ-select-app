@extends('layouts.app')

@section('title', 'Каталог — Мир цветов')

@section('content')
    <section class="hero">
        <div>
            <p class="eyebrow">Доставка по Москве и области</p>
            <h1>Цветы, которые говорят вместо слов</h1>
            <p class="lead">
                Заказывайте свежие композиции онлайн. Мы соберем букет мечты, согласуем доставку
                и привезем по указанному адресу в нужный час.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="#catalog-grid">Перейти к каталогу</a>
                @guest
                    <a class="btn btn-outline" href="{{ route('register') }}">Создать аккаунт</a>
                @else
                    <a class="btn btn-outline" href="{{ route('cabinet') }}">Личный кабинет</a>
                @endguest
            </div>
        </div>
        <div class="hero-card">
            <span>412×914 адаптив</span>
            <p>Интерфейс адаптирован под смартфоны, плавно реагирует на касания и жесты.</p>
        </div>
    </section>

    <section class="filters">
        <form method="GET" action="{{ route('catalog') }}" class="filters-form">
            <div class="filters-group">
                <label for="sort">Сортировать по</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="new" @selected($selectedSort === 'new')>новизне</option>
                    <option value="name" @selected($selectedSort === 'name')>названию</option>
                    <option value="price" @selected($selectedSort === 'price')>цене</option>
                    <option value="country" @selected($selectedSort === 'country')>стране поставщика</option>
                </select>
            </div>
            <div class="filters-group categories">
                <span>Категории:</span>
                <a href="{{ route('catalog', request()->except('category', 'page')) }}"
                   class="chip {{ $selectedCategory ? '' : 'active' }}">Все</a>
                @foreach($categories as $category)
                    <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug, 'page' => null]) }}"
                       class="chip {{ $selectedCategory === $category->slug ? 'active' : '' }}">
                        {{ $category->icon }} {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </form>
    </section>

    <section id="catalog-grid" class="catalog-grid">
        @forelse($products as $product)
            <article class="product-card" data-product-id="{{ $product->id }}">
                <div class="product-thumb" style="background-image: url('{{ $product->image_url }}')">
                    <span class="badge">{{ $product->category->name }}</span>
                </div>
                <div class="product-body">
                    <h3><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h3>
                    <p class="product-meta">
                        {{ $product->supplier_country }} · {{ $product->color }} · Остаток: {{ $product->stock }}
                    </p>
                    <div class="product-bottom">
                        <strong class="price">{{ $product->formatted_price }}</strong>
                        @auth
                            <button
                                class="btn btn-primary add-to-cart"
                                data-add-to-cart
                                data-product="{{ $product->id }}"
                                @if($product->stock === 0) disabled @endif
                            >
                                В корзину
                            </button>
                        @else
                            <a class="btn btn-outline" href="{{ route('login') }}">Войти</a>
                        @endauth
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <h3>По выбранным фильтрам товаров нет</h3>
                <p>Попробуйте изменить параметры или сбросить фильтры.</p>
                <a class="btn btn-primary" href="{{ route('catalog') }}">Сбросить фильтры</a>
            </div>
        @endforelse
    </section>

    {{ $products->links() }}
@endsection
