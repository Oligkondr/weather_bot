<?php

namespace App\Services;

use App\Models\City;
use Exception;
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

    /**
     * @throws Exception
     */
    public function getByName(string $name): mixed
    {
        return $this->getByCity($this->getCityByName($name));
    }

    public function getByCity(City $city): mixed
    {
        $response = Http::get(self::WEATHER_API_URL, [
            'lat' => $city->lat,
            'lon' => $city->lon,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'ru',
        ]);

        return $response->json();
    }

    /**
     * @throws Exception
     */
    public function getCityByName(string $name): City
    {
        $city = City::query()
            ->where('name', $name)
            ->first();

        if (!$city) {
            $response = Http::get(self::GEO_API_URL, [
                'q' => $name,
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang' => 'ru',
            ])->json()[0] ?? [];

            if (!$response) {
                throw new Exception('City not found');
            }

            $city = new City();
            $city->name = $name;
            $city->lat = $response['lat'];
            $city->lon = $response['lon'];
            $city->save();
        }

        return $city;
    }
}
