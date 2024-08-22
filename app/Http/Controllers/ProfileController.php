<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\JsonResponse;
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

    public function create()
    {
        dd('Create');
    }

    private function getCity()
    {
        return Auth::user()->cities;
    }
}
