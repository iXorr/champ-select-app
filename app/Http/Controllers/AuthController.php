<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ChangePasswordRequest;

use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('login', $data['login'])->first();

        if ($user->password !== $data['password'])
            return back()
                ->withErrors(['message' => 'Неправильные данные']);

        Auth::login($user);

        return redirect('/');
    }
    
    public function showProfile(Request $request)
    {
        return view('auth.profile', [
            'user' => $request->user()
        ]);
    }
    
    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        if ($user->password !== $data['current_password'])
            return back()
                ->withErrors(['message' => 'Пароль не изменён, вы ввели неправильный текущий пароль']);

        $user->update(['password' => $data['new_password']]);

        return back()
            ->with('message', 'Пароль изменён');
    }
    
    public function logout(Request $request)
    {
        Auth::logout($request->user());

        return redirect()
            ->route('login');
    }
}
