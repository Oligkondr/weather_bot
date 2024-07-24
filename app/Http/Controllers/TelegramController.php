<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use App\Services\Weather;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramController extends Controller
{
    private Update $update;

    private ?string $text;

    private int $chatId;

    private ?Client $client;

    private Weather $weather;

    private bool $isNewClient = false;

    public function webhook(Weather $weather): JsonResponse
    {
        $this->weather = $weather;

        $this->update = Telegram::getWebhookUpdate();

        $this->text = $this->update->message?->text;

        $this->chatId = $this->update->message?->chat->id;

        if ($this->update->message) {
            if ($this->text) {

                $this->client = $this->getClient();

                switch ($this->client->state) {
                    case Client::STATE_COMMAND:
                        $this->commandHandler();
                        break;
                    case Client::STATE_ADD_CITY:
                        $this->addCityHandler();
                        break;
                    case Client::STATE_DELETE_CITY:
                        $this->deleteCityHandler();
                        break;
                }
            } else {
                Telegram::sendMessage([
                    'chat_id' => $this->chatId,
                    'text' => 'Я не понимаю.',
                ]);

                $this->commandHelpHandler();
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    private function commandHandler(): void
    {
        switch ($this->text) {
            case '/start':
                $this->commandStartHandler();
                break;

            case '/help':
                $this->commandHelpHandler();
                break;

            case '/get_weather':
                $this->commandGetWeatherHandler();
                break;

            case '/add_city':
                $this->commandAddCityHandler();
                break;

            case '/delete_city':
                $this->commandDeleteCityHandler();
                break;

            case '/show_city':
                $this->commandShowCityHandler();
                break;

            case '/test':
                $this->commandTestHandler();
                break;

            default:
                Telegram::sendMessage([
                    'chat_id' => $this->chatId,
                    'text' => "{$this->client->first_name}, вы отправили неизвестную команду.",
                ]);
        }
    }

    private function addCityHandler(): void
    {
        collect(explode(",", $this->text))
            ->each(function (string $name) {
                $name = trim($name);
                $city = City::query()
                    ->where('name', 'like', $name)
                    ->first();

                if (!$city) {
                    try {
                        $city = $this->weather->getCityByName($name);

                    } catch (Exception $e) {
                        $text = "\"{$name}\", не знаем такого города.";

                        Telegram::sendMessage([
                            'chat_id' => $this->chatId,
                            'text' => $text,
                        ]);
                    }
                }

                if ($city) {
                    if ($this->client->cities->where('id', $city->id)->count()) {

                        $text = "{$name}, этот город уже есть.";

                    } else {
                        $this->client->cities()->attach($city->id);

                        $text = "{$name}, запомнили этот город.";
                    }

                    Telegram::sendMessage([
                        'chat_id' => $this->chatId,
                        'text' => $text,
                    ]);

                }
            });

        $this->client->state = Client::STATE_COMMAND;
        $this->client->save();
    }

    private function deleteCityHandler(): void
    {
        $name = $this->text;

        $city = City::query()
            ->where('name', 'like', $name)
            ->first();

        if ($city) {
            $this->client->cities()->detach($city->id);

            Telegram::sendMessage([
                'chat_id' => $this->chatId,
                'text' => 'Город были удален.',
                'reply_markup' => Keyboard::remove(['selective' => false]),
            ]);
        } elseif ($name != 'Отмена') {
            Telegram::sendMessage([
                'chat_id' => $this->chatId,
                'text' => "Город \"{$name}\" не найден.",
                'reply_markup' => Keyboard::remove(['selective' => false]),
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $this->chatId,
                'text' => "Передумали удалять города.",
                'reply_markup' => Keyboard::remove(['selective' => false]),
            ]);
        }

        $this->client->state = Client::STATE_COMMAND;
        $this->client->save();
    }

    private function getClient(): Client
    {
        $client = Client::query()
            ->where('ext_id', $this->update->message->from->id)
            ->first();

        if (!$client) {
            $client = new Client();
            $client->ext_id = $this->update->message->from->id;

            $this->isNewClient = true;
        }

        $client->first_name = $this->update->message->from->firstName;
        $client->last_name = $this->update->message->from->lastName;
        $client->username = $this->update->message->from->username;
        $client->language_code = $this->update->message->from->languageCode;
        $client->save();

        return $client;
    }

    private function commandStartHandler(): void
    {
        $text = $this->isNewClient
            ? 'мы рады, что вы теперь с нами!'
            : 'вы уже с нами!';

        Telegram::sendMessage([
            'chat_id' => $this->chatId,
            'text' => "{$this->client->first_name}, {$text}",
        ]);
    }

    private function commandHelpHandler(): void
    {
        $text = "Доступные команды:" . PHP_EOL;
        $text .= '/help - показывает доступные команды и их описание' . PHP_EOL;
        $text .= '/get_weather - показывает погоду в выбранных городах' . PHP_EOL;
        $text .= '/add_city - добавляет новые города' . PHP_EOL;
        $text .= '/delete_city - удаляет города' . PHP_EOL;
        $text .= '/show_city - показывает выбранные города' . PHP_EOL;

        Telegram::sendMessage([
            'chat_id' => $this->chatId,
            'text' => $text,
        ]);
    }

    private function commandGetWeatherHandler(): void
    {
        if ($this->client->cities->isEmpty()) {

            $textA = 'у вас пока нет городов, в которых вы хотите видеть погоду.';
            $textB = 'Напишите город (если несколько то через запятую) в котором хотите ее видеть.';

            Telegram::sendMessage([
                'chat_id' => $this->chatId,
                'text' => "{$this->client->first_name}, {$textA}",
            ]);

            Telegram::sendMessage([
                'chat_id' => $this->chatId,
                'text' => "{$this->client->first_name}, {$textB}",
            ]);

            $this->client->state = Client::STATE_ADD_CITY;
            $this->client->save();
        } else {
            $cities = $this->client->cities;

            foreach ($cities as $city) {
                $response = $this->weather->getByCity($city);

                $text = "{$response['name']}:" . PHP_EOL . PHP_EOL;
                $text .= "Температура: {$response['main']['temp']} °C" . PHP_EOL;
                $text .= Str::ucfirst($response['weather'][0]['description']) . PHP_EOL;
                $text .= "Скорость ветра: {$response['wind']['speed']} м/c" . PHP_EOL;

                Telegram::sendMessage([
                    'chat_id' => $this->chatId,
                    'text' => $text,
                ]);
            }
        }
    }

    private function commandShowCityHandler(): void
    {
        $text = $this->client->cities->isNotEmpty()
            ? "ваши города: {$this->client->cities->implode('name', ', ')}"
            : 'у вас пока нет городов, в которых вы хотите видеть погоду.';

        Telegram::sendMessage([
            'chat_id' => $this->chatId,
            'text' => "{$this->client->first_name}, {$text}",
        ]);
    }

    private function commandAddCityHandler(): void
    {
        Telegram::sendMessage([
            'chat_id' => $this->chatId,
            'text' => "{$this->client->first_name}, в каких еще городах хотите видеть погоду?",
        ]);

        $this->client->state = Client::STATE_ADD_CITY;
        $this->client->save();
    }

    private function commandDeleteCityHandler(): void
    {
        $this->client->state = Client::STATE_DELETE_CITY;
        $this->client->save();

        $cities = $this->client->cities;

        $replyMarkup = Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);

        foreach ($cities as $city) {
            $replyMarkup->row([
                Keyboard::button($city->name),
            ]);
        }

        $replyMarkup->row([
            Keyboard::button('Отмена'),
        ]);

        Telegram::sendMessage([
            'chat_id' => $this->chatId,
            'text' => "{$this->client->first_name}, в каком городе вы больше не хотите видеть погоду?",
            'reply_markup' => $replyMarkup,
        ]);
    }

    private function commandTestHandler(): void
    {
        Telegram::sendPhoto([
            'chat_id' => $this->chatId,
            'photo' => InputFile::create('https://weathercast.ru/storage/images/weather/lite-clouds.jpg'),
            'caption' => 'Test',
        ]);
    }
}
