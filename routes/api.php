<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('auth')->group(function () {

    // Login
    Route::post('login', [AuthController::class, 'login']);

    // Refresh Token
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum');

});

// Needs auth
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

});
