<?php

use App\Http\Controllers\Api\TelegramController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('guest')->group(function () {
    Route::get('telegram/code/{login}', [TelegramController::class, 'code'])->name('telegram.code');
});

Route::middleware('auth')->group(function () {
});
