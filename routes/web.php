<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function() {
  Route::get('/', DashboardController::class);

  Route::post('change-password', [AuthController::class, 'changePassword']);
  Route::get('profile', [AuthController::class, 'showProfile']);
  Route::get('logout', [AuthController::class, 'logout']);

  Route::resource('clients', ClientController::class);
  Route::post('clients/import', [ClientController::class, 'import']);

  Route::resource('orders', OrderController::class);
  Route::post('orders/update-status/{order}', [OrderController::class, 'updateStatus']);
  Route::post('orders/filter', [OrderController::class, 'filter']);

  Route::middleware('can:admin')->group(function() {
    Route::resource('users', UserController::class);
      
    Route::resource('products', ProductController::class);
    Route::post('products/import', [ProductController::class, 'import']);
  });
});
