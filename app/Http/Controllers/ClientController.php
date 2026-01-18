<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\ImportCsvRequest;

class ClientController extends Controller
{
    public function index()
    {
        return view('clients.index', [
            'clients' => Client::all()
        ]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(ClientRequest $request)
    {
        $data = $request->validated();

        $client = Client::create($data);
        
        return redirect()
            ->route('clients.index')
            ->with('message', 'Клиент создан');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', [
            'client' => $client
        ]);
    }

    public function update(ClientRequest $request, Client $client)
    {
        $data = $request->validated();

        $client->update($data);

        return redirect()
            ->route('clients.index')
            ->with('message', 'Клиент изменён');
    }

    public function destroy(Client $client)
    {
        // if ($client->orderItems->isNotEmpty()) {
        //     dd('not skipped');
        // }

        // dd('skipped');

        $client->delete();
        
        return redirect()
            ->route('clients.index')
            ->with('message', 'Клиент удалён');
    }

    public function import(ImportCsvRequest $request)
    {
        $data = $request->validated();

        $handle = fopen($data['file']->getRealPath(), 'r');
        $header = fgetcsv($handle, 0, ';');

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            if (!mb_check_encoding($row, 'UTF-8'))
                $row = mb_convert_encoding($row, 'UTF-8', 'Windows-1251');

            Client::create(array_combine($header, $row));
        }
        
        return redirect()
            ->route('clients.index')
            ->with('message', 'Импорт завершён');
    }
}
