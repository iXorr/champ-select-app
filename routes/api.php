<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'API отключен. Используйте web-интерфейс приложения.',
    ]);
});
