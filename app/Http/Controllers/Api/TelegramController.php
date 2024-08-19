<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class TelegramController extends Controller
{
    public function code(string $login)
    {
        $client = Client::query()
            ->where('login', $login)
            ->firstOrFail();

        $client->sendCode();

        return response()->json([
            'success' => true,
        ]);
    }
}
