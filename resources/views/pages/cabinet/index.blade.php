@extends('layouts.app')

@section('title', 'Личный кабинет — Мир цветов')

@section('content')
    <div class="cabinet-grid">
        <section class="card profile-card">
            <h2>Профиль</h2>
            <ul class="profile-list">
                <li><span>ФИО</span><strong>{{ $user->full_name }}</strong></li>
                <li><span>Логин</span><strong>{{ $user->login }}</strong></li>
                <li><span>Телефон</span><strong>{{ $user->phone }}</strong></li>
                <li><span>Email</span><strong>{{ $user->email }}</strong></li>
            </ul>
        </section>

        <section class="card cart-card">
            <div class="section-header">
                <h2>Корзина</h2>
                <span class="muted" data-cart-count>Товаров: {{ $cartItems->sum('quantity') }}</span>
            </div>
            <div data-cart-wrapper>
                <div class="empty-state {{ $cartItems->isEmpty() ? '' : 'hidden' }}" data-cart-empty>
                    <p>Корзина пуста. Добавьте товары в каталоге.</p>
                    <a class="btn btn-primary" href="{{ route('catalog') }}">Перейти в каталог</a>
                </div>
                <div data-cart-area class="{{ $cartItems->isEmpty() ? 'hidden' : '' }}">
                    <table class="cart-table">
                    <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $item)
                        <tr data-cart-row="{{ $item->id }}">
                            <td>
                                <strong>{{ $item->product->name }}</strong>
                                <p class="muted">{{ $item->product->supplier_country }} · Остаток {{ $item->product->stock }}</p>
                            </td>
                            <td>{{ $item->product->formatted_price }}</td>
                            <td>
                                <div class="quantity" data-quantity data-cart-item="{{ $item->id }}">
                                    <button type="button" data-change="-1" data-cart-item="{{ $item->id }}">−</button>
                                    <input type="number" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                                    <button type="button" data-change="1" data-cart-item="{{ $item->id }}">+</button>
                                </div>
                            </td>
                            <td data-cart-subtotal>{{ number_format($item->subtotal, 0, '', ' ') }} ₽</td>
                            <td>
                                <button type="button" class="icon-btn" data-remove data-cart-item="{{ $item->id }}">×</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="cart-total">
                    <span>Итого:</span>
                    <strong data-cart-total>{{ number_format($cartTotal, 0, '', ' ') }} ₽</strong>
                </div>
                </div>
            </div>
        </section>

        <section class="card order-card">
            <h2>Оформление заказа</h2>
            <form action="{{ route('orders.store') }}" method="POST" class="order-form" novalidate>
                @csrf
                <div class="form-grid">
                    <label>
                        <span>ФИО получателя</span>
                        <input type="text" name="contact_name" value="{{ old('contact_name', $user->full_name) }}" required>
                        @error('contact_name')<small>{{ $message }}</small>@enderror
                    </label>
                    <label>
                        <span>Телефон</span>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $user->phone) }}" required>
                        @error('contact_phone')<small>{{ $message }}</small>@enderror
                    </label>
                    <label>
                        <span>Email</span>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $user->email) }}">
                        @error('contact_email')<small>{{ $message }}</small>@enderror
                    </label>
                    <label class="wide">
                        <span>Адрес доставки</span>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Город, улица, дом, подъезд" required>
                        @error('address')<small>{{ $message }}</small>@enderror
                    </label>
                    <label>
                        <span>Дата</span>
                        <input type="date" name="preferred_date" value="{{ old('preferred_date') ?? now()->addDay()->toDateString() }}" required>
                        @error('preferred_date')<small>{{ $message }}</small>@enderror
                    </label>
                    <label>
                        <span>Время</span>
                        <input type="time" name="preferred_time" value="{{ old('preferred_time') ?? '12:00' }}" required>
                        @error('preferred_time')<small>{{ $message }}</small>@enderror
                    </label>
                    <label>
                        <span>Оплата</span>
                        <select name="payment_method" required>
                            <option value="cash" @selected(old('payment_method') === 'cash')>Наличными</option>
                            <option value="card" @selected(old('payment_method') === 'card')>Банковской картой</option>
                        </select>
                        @error('payment_method')<small>{{ $message }}</small>@enderror
                    </label>
                    <label class="wide">
                        <span>Комментарий</span>
                        <textarea name="notes" rows="3" placeholder="Например, «позвоните за 30 минут до доставки»">{{ old('notes') }}</textarea>
                    </label>
                </div>
                <button class="btn btn-primary" type="submit" data-order-submit @if($cartItems->isEmpty()) disabled @endif>
                    Сформировать заказ
                </button>
            </form>
        </section>

        <section class="card orders-card">
            <h2>Мои заказы</h2>
            @if($orders->isEmpty())
                <p class="muted">История заказов появится после первого оформления.</p>
            @else
                <div class="orders-list">
                    @foreach($orders as $order)
                        @php
                            $statusMap = [
                                'new' => ['Новый', 'status-new'],
                                'in_progress' => ['В работе', 'status-progress'],
                                'done' => ['Выполнен', 'status-done'],
                                'canceled' => ['Отменен', 'status-cancel'],
                            ];
                            [$text, $class] = $statusMap[$order->status];
                        @endphp
                        <article class="order-card-item">
                            <header>
                                <div>
                                    <strong>Заказ №{{ $order->id }}</strong>
                                    <span class="muted">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <span class="status {{ $class }}">{{ $text }}</span>
                            </header>
                            <p>Сумма: {{ $order->formatted_total }} · Товаров: {{ $order->items->sum('quantity') }}</p>
                            <p class="muted">Адрес: {{ $order->address }} · Дата: {{ $order->preferred_date->format('d.m.Y') }} в {{ $order->preferred_time_formatted }}</p>
                            <ul>
                                @foreach($order->items as $item)
                                    <li>{{ $item->product->name }} × {{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                            @if($order->status === \App\Models\Order::STATUS_NEW)
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Удалить заказ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline" type="submit">Отменить</button>
                                </form>
                            @elseif($order->status === \App\Models\Order::STATUS_CANCELED && $order->cancellation_reason)
                                <p class="muted">Причина: {{ $order->cancellation_reason }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection
