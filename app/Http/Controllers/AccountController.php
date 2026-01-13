<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordChangeRequest;

class AccountController extends Controller
{
    public function edit()
    {
        return view('account.password');
    }

    public function update(PasswordChangeRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($data['current_password'] !== $user->password) {
            return back()
                ->withErrors(['current_password' => 'Пароль неизменен, вы ввели неверный текущий пароль'])
                ->withInput();
        }

        $user->update(['password' => $data['new_password']]);

        return redirect()
            ->route('account.password.edit')
            ->with('status', 'Пароль обновлен');
    }
}
