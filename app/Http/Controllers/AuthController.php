<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\SendRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class AuthController extends Controller
{
    public function code(string $login): Response|ResponseFactory
    {
        return inertia('Code', [
            'login' => $login,
        ]);
    }

    public function auth(AuthRequest $request): RedirectResponse
    {
        $client = $request->client;

        Auth::login($client);

        $client->code = null;
        $client->save();

        return to_route('welcome');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return to_route('welcome');
    }

    public function login(): Response|ResponseFactory
    {
        return inertia('Login');
    }

    public function send(SendRequest $request): RedirectResponse
    {
        $client = $request->client;

        $client->sendCode();

        return to_route('code', [
            'login' => $client->login,
        ]);
    }
}
