<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'index'])->name('catalog');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/cabinet', CabinetController::class)->name('cabinet');

    Route::post('/cart/items', [CartController::class, 'store'])->name('cart.items.store');
    Route::patch('/cart/items/{cartItem}', [CartController::class, 'update'])->name('cart.items.update');
    Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy'])->name('cart.items.destroy');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::match(['patch', 'post'], '/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    });
