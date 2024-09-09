<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\WeatherService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProfileController extends Controller
{
    public function profile(): Response|ResponseFactory
    {
        return inertia('Profile', [
            'cities' => fn() => $this->getCity(),
        ]);
    }

    public function delete(City $city): JsonResponse
    {
        $client = Auth::user();

        $client->cities()->detach($city->id);

        return response()->json([
            'success' => true,
        ]);
    }

    public function create(Request $request, WeatherService $weather)
    {
        $client = Auth::user();

        $name = $request->input('city');

        $city = City::query()
            ->where('name', 'like', $name)
            ->first();

        $error = null;

        if (!$city) {
            try {
                $city = $weather->getCityByName($name);
            } catch (Exception $e) {
                $error = "\"{$name}\", не знаем такого города.";
            }
        }

        if ($city) {
            if ($client->cities->where('id', $city->id)->count()) {
                $error = "{$name}, этот город уже есть.";
            } else {
                $client->cities()->attach($city->id);
            }
        }

        return response()->json(
            $error ? [
                'success' => false,
                'message' => $error,
            ] : [
                'success' => true,
            ]);
    }

    private function getCity()
    {
        return Auth::user()->cities;
    }
}
