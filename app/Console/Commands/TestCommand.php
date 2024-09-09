<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Services\WeatherService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(WeatherService $weather)
    {
        dd(Storage::url('images/weather/clear_sky.jpeg'));
    }
}
