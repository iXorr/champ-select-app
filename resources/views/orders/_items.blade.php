@php
    $preparedItems = old('items', isset($order)
        ? $order->items->map(fn($item) => [
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'discount' => $item->discount,
        ])->toArray()
        : []);

    if (empty($preparedItems)) {
        $preparedItems = [
            ['product_id' => '', 'quantity' => 1, 'discount' => 0],
        ];
    }
@endphp

<div class="table-responsive">
    <table class="table align-middle">
        <thead class="table-light">
        <tr>
            <th style="width:40%">Товар</th>
            <th style="width:20%">Количество</th>
            <th style="width:20%">Скидка, %</th>
            <th class="text-end">Действия</th>
        </tr>
        </thead>
        <tbody id="items-rows">
        @foreach($preparedItems as $index => $item)
            <tr>
                <td>
                    <select name="items[{{ $index }}][product_id]" class="form-select" required>
                        <option value="">Выберите товар</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected((string)($item['product_id'] ?? '') === (string)$product->id)>
                                {{ $product->title }} — {{ number_format($product->price, 0, ',', ' ') }} ₽
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control"
                           min="1" value="{{ $item['quantity'] ?? 1 }}" required>
                </td>
                <td>
                    <input type="number" name="items[{{ $index }}][discount]" class="form-control"
                           min="0" max="100" value="{{ $item['discount'] ?? 0 }}">
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-row">Удалить</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-between">
    <button type="button" class="btn btn-outline-primary btn-sm" id="add-item">Добавить позицию</button>
</div>

<template id="item-template">
    <tr>
        <td>
            <select data-name="items[__INDEX__][product_id]" class="form-select" required>
                <option value="">Выберите товар</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->title }} — {{ number_format($product->price, 0, ',', ' ') }} ₽
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" data-name="items[__INDEX__][quantity]" class="form-control" min="1" value="1" required>
        </td>
        <td>
            <input type="number" data-name="items[__INDEX__][discount]" class="form-control" min="0" max="100" value="0">
        </td>
        <td class="text-end">
            <button type="button" class="btn btn-outline-danger btn-sm remove-row">Удалить</button>
        </td>
    </tr>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const rows = document.getElementById('items-rows');
    const template = document.getElementById('item-template');

    document.getElementById('add-item')?.addEventListener('click', () => {
        const index = rows.children.length;
        const clone = template.content.cloneNode(true);
        clone.querySelectorAll('[data-name]').forEach((input) => {
            input.name = input.dataset.name.replace('__INDEX__', index);
        });
        rows.appendChild(clone);
    });

    rows.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-row')) {
            const tr = event.target.closest('tr');
            tr?.remove();
        }
    });
});
</script>
@endpush
