<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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
  Route::view('/', 'dashboard');

  Route::post('change-password', [AuthController::class, 'changePassword']);
  Route::get('profile', [AuthController::class, 'showProfile']);
  Route::get('logout', [AuthController::class, 'logout']);

  Route::middleware('can:admin')->group(function() {
    Route::resource('users', UserController::class);
  });
});
