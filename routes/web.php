<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

Route::post('telegram/webhook', [WebhookController::class, 'webhook'])->name('telegram.webhook');

Route::middleware('guest')->group(function () {
    Route::get('telegram/bot/{token}', [TelegramController::class, 'bot'])->name('telegram.bot');
    Route::post('telegram/bot/{client}', [TelegramController::class, 'bind'])->name('telegram.bind');

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('send', [AuthController::class, 'send'])->name('send');

    Route::get('code/{login}', [AuthController::class, 'code'])->name('code');
    Route::post('auth/{login}', [AuthController::class, 'auth'])->name('auth');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');

});

//require __DIR__ . '/auth.php';
