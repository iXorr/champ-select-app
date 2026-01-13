<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('login', $data['login'])->first();

        if (!$user || $user->password !== $data['password']) {
            return back()
                ->withErrors(['login' => 'Неверный логин или пароль'])
                ->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME)
            ->with('status', 'Добро пожаловать!');
    }

    public function profile(Request $request)
    {
        return view('auth.profile', ['user' => $request->user()]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'Вы вышли из системы');
    }
}
