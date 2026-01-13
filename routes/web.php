<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    Route::get('/account/password', [AccountController::class, 'edit'])->name('account.password.edit');
    Route::put('/account/password', [AccountController::class, 'update'])->name('account.password.update');

    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/dashboard', DashboardController::class);

    Route::resource('clients', ClientController::class);
    Route::post('clients/import', [ClientController::class, 'import'])->name('clients.import');

    Route::resource('orders', OrderController::class);

    Route::resource('products', ProductController::class);
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');

    Route::middleware('can:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});
