@props(['orders'])

<div class="overflow-auto">
  <table class="table align-middle">
    <thead>
      <tr>
        <th scope="col">Номер</th>
        <th scope="col">Клиент</th>
        <th scope="col">Пользователь-создатель</th>
        <th scope="col">Общая сумма</th>
        <th scope="col">Статус</th>
        <th scope="col">Дата создания</th>
        <th scope="col">Дата отгрузки</th>
        <th></th>
      </tr>
    </thead>
    
    <tbody>
      @foreach($orders as $order)

      <tr>
        <td>{{ $order->id }}</th>
        <td>{{ $order->client->full_name }}</td>
        <td>{{ $order->user->full_name }}</td>
        <td>{{ $order->total_sum }}</td>

        <td>
          <form 
            method="post"
            action="/orders/update-status/{{ $order->id }}"
            enctype="multipart/form-data" 
            class="update-status-form" 
          >
            @csrf

            <select class="form-select" name="status">
              <option 
                value="Новый" 
                {{ $order->status === 'Новый' ? 'selected' : null }}
              >
                Новый
              </option>
              
              <option 
                value="Отгрузка" 
                {{ $order->status === 'Отгрузка' ? 'selected' : null }}
              >
                Отгрузка
              </option>

              <option 
                value="Доставка" 
                {{ $order->status === 'Доставка' ? 'selected' : null }}
              >
                Доставка
              </option>

              <option 
                value="Выдан" 
                {{ $order->status === 'Выдан' ? 'selected' : null }}
              >
                Выдан
              </option>

              <option 
                value="Отменен" 
                {{ $order->status === 'Отменен' ? 'selected' : null }}
              >
                Отменен
              </option>
            </select>
          </form>
        </td>

        <td>{{ $order->created_at }}</td>
        <td>{{ $order->shipped_at ? $order->shipped_at : '-' }}</td>

        <td class="d-flex gap-2">
          <a 
            href="{{ route('orders.edit', $order->id) }}" 
            class="btn btn-outline-secondary" 
          >
            Изменить
          </a>

          <form
            method="post"
            action="{{ route('orders.destroy', $order->id) }}"
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
