<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Inertia\ResponseFactory;

class ProfileController extends Controller
{
    public function profile(): Response|ResponseFactory
    {
        return inertia('Profile');
    }
}
