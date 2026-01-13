<div class="mb-3">
    <label class="form-label">ФИО</label>
    <input type="text" name="full_name" class="form-control"
           value="{{ old('full_name', $client->full_name ?? '') }}" required>
</div>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $client->email ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Телефон</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $client->phone ?? '') }}" required>
    </div>
</div>
<div class="mb-3 mt-3">
    <label class="form-label">Адрес</label>
    <input type="text" name="address" class="form-control"
           value="{{ old('address', $client->address ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Заметка</label>
    <textarea name="note" class="form-control" rows="2">{{ old('note', $client->note ?? '') }}</textarea>
</div>
