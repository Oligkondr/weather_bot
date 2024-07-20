<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    private array $message;

    public function webhook()
    {
        $this->message = request('message');

        switch ($this->message['text']) {
            case '/start':
                $this->start();
                break;

            case '/help':
                Telegram::sendMessage([
                    'chat_id' => $this->message['chat']['id'],
                    'text' => "Пока что есть только команды:",
                ]);
                break;

            default:
                Telegram::sendMessage([
                    'chat_id' => $this->message['chat']['id'],
                    'text' => "{$this->message['from']['first_name']}, вы отправили неизвестную команду.",
                ]);
        }
    }

    private function start()
    {
        $client = Client::query()
            ->where('ext_id', $this->message['from']['id'])
            ->first();

        if ($client) {
            $text = 'вы уже с нами!';
        } else {
            $client = new Client();
            $client->ext_id = $this->message['from']['id'];

            $text = 'мы рады, что вы теперь с нами!';
        }

        Telegram::sendMessage([
            'chat_id' => $this->message['chat']['id'],
            'text' => "{$this->message['from']['first_name']}, {$text}",
        ]);

        $client->first_name = $this->message['from']['first_name'];
        $client->last_name = $this->message['from']['last_name'];
        $client->username = $this->message['from']['username'];
        $client->language_code = $this->message['from']['language_code'];
        $client->save();
    }
}
