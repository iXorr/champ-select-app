@extends('layout')
@props(['clients'])

@section('content')

<div class="mb-3 d-flex flex-wrap gap-3 justify-content-between">
  <div class="d-flex gap-4 align-items-center">
    <h4 class="mb-0">Клиенты</h4>

    <form
      method="post"
      action="/clients/import"
      enctype="multipart/form-data" 
    >
      @csrf

      <div class="row g-3">
        <div class="col-lg-8">
          <input 
            type="file" 
            name="file" 
            class="form-control" 
          />
        </div>

        <div class="col-lg-4">
          <button 
            type="submit" 
            class="btn btn-outline-primary" 
          >
            Импорт CSV
          </button>
        </div>
      </div>
    </form>
  </div>

  <a 
    href="{{ route('clients.create') }}" 
    class="btn btn-primary" 
  >
    Добавить
  </a>
</div>

@if($clients->isNotEmpty())

<div class="overflow-auto">
  <table class="table align-middle">
    <thead>
      <tr>
        <th scope="col">ФИО</th>
        <th scope="col">Почта</th>
        <th scope="col">Адрес доставки</th>
        <th scope="col">Контактный номер</th>
        <th scope="col">Пометка</th>
        <th></th>
      </tr>
    </thead>
    
    <tbody>
      @foreach($clients as $client)

      <tr>
        <td>{{ $client->full_name }}</th>
        <td>{{ $client->email }}</td>
        <td>{{ $client->address }}</td>
        <td>{{ $client->phone }}</td>
        <td>{{ $client->note ? $client->note : '-' }}</td>

        <td class="d-flex gap-2">
          <a 
            href="{{ route('clients.edit', $client->id) }}" 
            class="btn btn-outline-secondary" 
          >
            Изменить
          </a>

          <form
            method="post"
            action="{{ route('clients.destroy', $client->id) }}"
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

@else

<div class="alert alert-warning" role="alert">
  Список пуст
</div>

@endif

@endsection
