<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use App\Services\Weather;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    private array $message;

    private ?Client $client;

    private Weather $weather;

    private bool $isNewClient = false;

    public function webhook(Weather $weather): void
    {
        $this->weather = $weather;

        $this->message = request('message');

        $this->client = $this->getClient();

        switch ($this->client->state) {
            case Client::STATE_COMMAND:
                $this->commandHandler();
                break;
            case Client::STATE_CITIES:
                $this->citiesHandler();
                break;
        }
    }

    private function commandHandler(): void
    {
        switch ($this->message['text']) {
            case '/start':
                $this->commandStartHandler();
                break;

            case '/help':
                $this->commandHelpHandler();
                break;

            case '/get_weather':
                $this->commandGetWeatherHandler();
                break;

            default:
                Telegram::sendMessage([
                    'chat_id' => $this->message['chat']['id'],
                    'text' => "{$this->message['from']['first_name']}, вы отправили неизвестную команду.",
                ]);
        }
    }

    private function citiesHandler(): void
    {
        collect(explode(",", $this->message['text']))
            ->each(function (string $name) {
                $name = trim($name);
                $city = City::query()
                    ->where('name', 'like', $name)
                    ->first();

                if (!$city) {
                    try {
                        $city = $this->weather->getCityByName($name);

                    } catch (\Exception $e) {
                        $text = "\"{$name}\", не знаем такого города.";

                        Telegram::sendMessage([
                            'chat_id' => $this->message['chat']['id'],
                            'text' => $text,
                        ]);
                    }
                }

                if ($city) {
                    $this->client->cities()->attach($city->id);

                    $text = "{$name}, запомнили этот город.";

                    Telegram::sendMessage([
                        'chat_id' => $this->message['chat']['id'],
                        'text' => $text,
                    ]);
                }
            });

        $this->client->state = Client::STATE_COMMAND;
        $this->client->save();
    }

    private function getClient(): Client
    {
        $client = Client::query()
            ->where('ext_id', $this->message['from']['id'])
            ->first();

        if (!$client) {
            $client = new Client();
            $client->ext_id = $this->message['from']['id'];

            $this->isNewClient = true;
        }

        $client->first_name = $this->message['from']['first_name'];
        $client->last_name = $this->message['from']['last_name'];
        $client->username = $this->message['from']['username'];
        $client->language_code = $this->message['from']['language_code'];
        $client->save();

        return $client;
    }

    private function commandStartHandler(): void
    {
        $text = $this->isNewClient
            ? 'мы рады, что вы теперь с нами!'
            : 'вы уже с нами!';

        Telegram::sendMessage([
            'chat_id' => $this->message['chat']['id'],
            'text' => "{$this->message['from']['first_name']}, {$text}",
        ]);
    }

    private function commandHelpHandler(): void
    {
        $text = "Доступные команды:" . PHP_EOL;
        $text .= '/help' . PHP_EOL;
        $text .= '/get_weather' . PHP_EOL;

        Telegram::sendMessage([
            'chat_id' => $this->message['chat']['id'],
            'text' => $text,
        ]);
    }

    private function commandGetWeatherHandler(): void
    {
        if ($this->client->cities->isEmpty()) {

            $textA = 'у вас пока нет городов, в которых вы хотите видеть погоду.';
            $textB = 'Напишите город (если несколько то через запятую) в котором хотите ее видеть.';

            Telegram::sendMessage([
                'chat_id' => $this->message['chat']['id'],
                'text' => "{$this->client->first_name}, {$textA}",
            ]);

            Telegram::sendMessage([
                'chat_id' => $this->message['chat']['id'],
                'text' => "{$this->client->first_name}, {$textB}",
            ]);

            $this->client->state = Client::STATE_CITIES;
            $this->client->save();
        } else {
            Telegram::sendMessage([
                'chat_id' => $this->message['chat']['id'],
                'text' => "Ваши города: {$this->client->cities->implode('name', ', ')}",
            ]);
        }
    }
}
