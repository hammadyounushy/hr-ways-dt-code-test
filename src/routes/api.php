<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('translations', TranslationController::class);
    Route::get('translations/export', [TranslationController::class, 'export']);
    Route::get('translations/search', [TranslationController::class, 'search']);
});
