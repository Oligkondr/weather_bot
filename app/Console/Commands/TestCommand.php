<?php

namespace App\Console\Commands;

use App\Services\Weather;
use Illuminate\Console\Command;
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
     */
    public function handle(Weather $weather)
    {
        $coords = $weather->getCityByName('Москваdf');
        dd($coords);
    }
}
