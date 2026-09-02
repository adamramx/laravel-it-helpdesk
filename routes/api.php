<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API berhasil berjalan',
    ]);
});

Route::post('/login', [
    AuthController::class,
    'login',
]);