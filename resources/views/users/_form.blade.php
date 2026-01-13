<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">ФИО</label>
        <input type="text" name="full_name" class="form-control"
               value="{{ old('full_name', $user->full_name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Логин</label>
        <input type="text" name="login" class="form-control"
               value="{{ old('login', $user->login ?? '') }}" required>
    </div>
</div>
<div class="row g-3 mt-2">
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $user->email ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Роль</label>
        <select name="role" class="form-select" required>
            @foreach(['admin' => 'Админ', 'manager' => 'Менеджер'] as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $user->role ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row g-3 mt-2">
    <div class="col-md-6">
        <label class="form-label">Пароль @isset($user)<span class="text-muted">(если нужен)</span>@endisset</label>
        <input type="password" name="password" class="form-control" @empty($user) required @endempty>
    </div>
    <div class="col-md-6">
        <label class="form-label">Подтверждение пароля</label>
        <input type="password" name="password_confirmation" class="form-control" @empty($user) required @endempty>
    </div>
</div>
