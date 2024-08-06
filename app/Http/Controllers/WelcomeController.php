<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class WelcomeController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Welcome');
    }
}
