<?php

namespace App\Http\Controllers;

use App\Http\Requests\BindRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\ResponseFactory;

class TelegramController extends Controller
{
    public function bot(string $token): Response|ResponseFactory|RedirectResponse
    {
        $appKey = config('app.key');

        $client = Client::query()
            ->where(DB::raw("MD5(CONCAT(ext_id, '{$appKey}'))"), $token)
            ->first();

        if ($client->login) {
            return to_route('cod', [
                'login' => $client->login,
            ]);
        } else {
            $client->sendCode();

            return inertia('Bot', [
                'client' => $client,
            ]);
        }
    }

    public function bind(BindRequest $request, Client $client): RedirectResponse
    {
        $client->code = null;
        $client->login = $request->validated('login');
        $client->save();

        Auth::login($client);

        return to_route('welcome');
    }
}
