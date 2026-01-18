@extends('layout')
@props(['users'])

@section('content')

<div class="mb-3 d-flex flex-wrap gap-3 justify-content-between">
  <h4 class="mb-0">Пользователи</h4>

  <a 
    href="{{ route('users.create') }}" 
    class="btn btn-primary" 
  >
    Добавить
  </a>
</div>

@if($users->isNotEmpty())

<div class="overflow-auto">
  <table class="table align-middle text-truncate">
    <thead>
      <tr>
        <th scope="col">ФИО</th>
        <th scope="col">Логин</th>
        <th scope="col">Почта</th>
        <th></th>
      </tr>
    </thead>
    
    <tbody>
      @foreach($users as $user)

      <tr>
        <td>{{ $user->full_name }}</th>
        <td>{{ $user->login }}</td>
        <td>{{ $user->email }}</td>

        <td class="d-flex gap-2">
          <a 
            href="{{ route('users.edit', $user->id) }}" 
            class="btn btn-outline-secondary" 
          >
            Изменить
          </a>

          <form
            method="post"
            action="{{ route('users.destroy', $user->id) }}"
            enctype="multipart/form-data"
          >
            @csrf
            @method('DELETE')

            <button 
              type="submit" 
              class="btn btn-outline-danger" 
            >
              Удалить
            </button>
          </form>
        </td>
      </tr>

      @endforeach
    </tbody>
  </table>
</div>

@endif

@endsection
