<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TelegramController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('telegram/webhook', [WebhookController::class, 'webhook'])->name('telegram.webhook');

Route::get('telegram/bot/{token}', [TelegramController::class, 'bot'])->name('telegram.bot');
Route::get('telegram/code/{login}', [TelegramController::class, 'code'])->name('telegram.code');
Route::post('telegram/bot/{client}', [TelegramController::class, 'bind'])->name('telegram.bind');

require __DIR__ . '/auth.php';
