<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TelegramController extends Controller
{
    public function bot(string $token)
    {
        $appKey = config('app.key');

        $client = Client::query()
            ->where(DB::raw("MD5(CONCAT(ext_id, '{$appKey}'))"), $token)
            ->first();

        return Inertia::render('Link');
    }
}
