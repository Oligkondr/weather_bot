<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::any('telegram/webhook', [\App\Http\Controllers\TelegramController::class, 'webHook']);
