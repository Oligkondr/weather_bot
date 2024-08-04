<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class TelegramController extends Controller
{
    public function bot(string $token): Response
    {
        $appKey = config('app.key');

        $client = Client::query()
            ->where(DB::raw("MD5(CONCAT(ext_id, '{$appKey}'))"), $token)
            ->first();

        $code = rand(1000, 9999);

        $client->verification_code = $code;
        $client->save();

        return Inertia::render('Link', [
            'client' => $client,
        ]);
    }
}
