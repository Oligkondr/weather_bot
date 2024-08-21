<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProfileController extends Controller
{
    public function profile(): Response|ResponseFactory
    {
        $client = Auth::user();

        return inertia('Profile', [
            'cities' => $client->cities,
        ]);
    }
}
