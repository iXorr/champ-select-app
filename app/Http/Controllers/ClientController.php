<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('orders')
            ->orderBy('full_name')
            ->get();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(ClientRequest $request)
    {
        $client = Client::create($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('status', 'Клиент добавлен');
    }

    public function show(Client $client)
    {
        $client->load('orders');

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('status', 'Клиент обновлен');
    }

    public function destroy(Client $client)
    {
        if ($client->orders()->exists()) {
            return back()->withErrors([
                'general' => 'Нельзя удалить клиента с заказами',
            ]);
        }

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('status', 'Клиент удален');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        if (!$file) {
            return back()->withErrors(['file' => 'Файл не передан']);
        }

        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 0, ';');

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            $row = $this->convertRow($row);
            $data = $header ? array_combine($header, $row) : $row;

            Client::create([
                'full_name' => $data['full_name'] ?? $row[0],
                'email' => $data['email'] ?? $row[1] ?? '',
                'address' => $data['address'] ?? $row[2] ?? '',
                'phone' => $data['phone'] ?? $row[3] ?? '',
                'note' => $data['note'] ?? $row[4] ?? null,
            ]);
        }

        fclose($handle);

        return redirect()
            ->route('clients.index')
            ->with('status', 'Импорт завершен');
    }

    private function convertRow(array $row): array
    {
        return array_map(function ($value) {
            $value = (string)$value;

            return mb_detect_encoding($value, 'UTF-8', true)
                ? $value
                : iconv('Windows-1251', 'UTF-8//IGNORE', $value);
        }, $row);
    }
}
