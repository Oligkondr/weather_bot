<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Weather
{
    private const WEATHER_API_URL = 'https://api.openweathermap.org/data/2.5/weather';
    private const GEO_API_URL = 'http://api.openweathermap.org/geo/1.0/direct';

    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('api.weather.key');
    }

    public function getByCoords(string $lat, string $lon)
    {
        $response = Http::get(self::WEATHER_API_URL, [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey,
        ]);

        return $response->json();
    }
}
