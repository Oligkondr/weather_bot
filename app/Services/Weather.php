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

    public function getByCity(string $city)
    {
        [
            'lat' => $lat,
            'lon' => $lon,
        ] = $this->getCoordsByCity($city);

        return $this->getByCoords($lat, $lon);
    }

    public function getByCoords(string $lat, string $lon)
    {
        $response = Http::get(self::WEATHER_API_URL, [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'ru',
        ]);

        return $response->json();
    }

    public function getCoordsByCity(string $city): array
    {
        $response = Http::get(self::GEO_API_URL, [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'ru',
        ])->json()[0] ?? [];

        return [
            'lat' => $response['lat'],
            'lon' => $response['lon'],
        ];
    }
}
