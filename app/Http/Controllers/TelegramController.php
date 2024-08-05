<?php

namespace App\Http\Controllers;

use App\Http\Requests\BindRequest;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

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
            Telegram::sendMessage([
                'chat_id' => $client->ext_id,
                'text' => $client->code,
            ]);

            return Inertia::render('Bot', [
                'client' => $client,
            ]);
        }
    }

    public function bind(BindRequest $request, Client $client)
    {
        dd($request->validated(), $client->toArray());
    }
}
