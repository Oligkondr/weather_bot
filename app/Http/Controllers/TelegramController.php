<?php

namespace App\Http\Controllers;

use App\Http\Requests\BindRequest;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class TelegramController extends Controller
{
    public function bot(string $token): Response
    {
        $appKey = config('app.key');

        $client = Client::query()
            ->where(DB::raw("MD5(CONCAT(ext_id, '{$appKey}'))"), $token)
            ->first();

        $client->code = rand(1000, 9999);
        $client->save();

        if ($client->login) {
            dd($client->login);
        } else {
//            Telegram::sendMessage([
//                'chat_id' => $client->ext_id,
//                'text' => $client->code,
//            ]);

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
