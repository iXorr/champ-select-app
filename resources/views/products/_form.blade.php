@php $features = isset($product) ? optional($product->features->first()) : null; @endphp
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Название</label>
        <input type="text" name="title" class="form-control"
               value="{{ old('title', $product->title ?? '') }}" @isset($product) readonly @endisset required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Производитель</label>
        <input type="text" name="manufacturer" class="form-control"
               value="{{ old('manufacturer', $product->manufacturer ?? '') }}" required>
    </div>
</div>
<div class="row g-3 mt-2">
    <div class="col-md-4">
        <label class="form-label">Цена</label>
        <input type="number" name="price" class="form-control"
               value="{{ old('price', $product->price ?? 0) }}" min="0" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Единица</label>
        <select name="unit" class="form-select" @isset($product) disabled @endisset required>
            @foreach(['кг','шт','г','л','мл'] as $unit)
                <option value="{{ $unit }}" @selected(old('unit', $product->unit ?? '') === $unit)>{{ $unit }}</option>
            @endforeach
        </select>
        @isset($product)
            <input type="hidden" name="unit" value="{{ $product->unit }}">
        @endisset
    </div>
    <div class="col-md-4">
        <label class="form-label">Изображение (jpg до 2 МБ)</label>
        <input type="file" name="image" class="form-control" accept=".jpg,.jpeg">
    </div>
</div>
<div class="row g-3 mt-2">
    <div class="col-md-6">
        <label class="form-label">Обжарка</label>
        <input type="text" name="roast_level" class="form-control"
               value="{{ old('roast_level', $features?->roast_level ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Страна</label>
        <input type="text" name="country" class="form-control"
               value="{{ old('country', $features?->country ?? '') }}">
    </div>
</div>
<div class="mt-3">
    <label class="form-label">Короткое описание</label>
    <input type="text" name="short_description" class="form-control"
           value="{{ old('short_description', $product->short_description ?? '') }}" required>
</div>
<div class="mt-3">
    <label class="form-label">Описание</label>
    <textarea name="description" rows="4" class="form-control" required>{{ old('description', $product->description ?? '') }}</textarea>
</div>
