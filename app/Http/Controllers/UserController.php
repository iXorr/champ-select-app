<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => User::all()
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);
        
        return redirect()
            ->route('users.index')
            ->with('message', 'Пользователь создан');
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!$data['password'])
            $data['password'] = $user->password;

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('message', 'Пользователь изменён');
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()
            ->route('users.index')
            ->with('message', 'Пользователь удалён');
    }
}
