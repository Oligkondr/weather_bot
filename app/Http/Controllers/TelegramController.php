<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook()
    {
        $message = request('message');

        switch ($message['text']) {
            case '/start':

                break;

            default:
                Telegram::sendMessage([
                    'chat_id' => $message['chat']['id'],
                    'text' => "{$message['from']['first_name']}, твоя команда - говно."
                ]);
        }
    }
}
