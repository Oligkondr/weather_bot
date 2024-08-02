<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function bot(string $token)
    {
        dd($token);
    }
}
