<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'login' => $data['login'],
            'name' => $data['full_name'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'client',
            'password' => $data['password'],
        ]);

        Auth::login($user);

        return redirect()->route('cabinet')->with('success', 'Регистрация прошла успешно. Добро пожаловать!');
    }

    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('cabinet'));
        }

        return back()->withErrors([
            'login' => 'Неверная пара логин/пароль.',
        ])->onlyInput('login');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('catalog');
    }
}
