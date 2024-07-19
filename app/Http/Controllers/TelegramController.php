<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function webHook()
    {
        file_put_contents(date('YmdHis').'.log', request());
    }
}
