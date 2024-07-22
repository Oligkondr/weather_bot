<?php

namespace App\Console\Commands;

use App\Services\Weather;
use Exception;
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
     * @throws Exception
     */
    public function handle(Weather $weather)
    {
        Telegram::setWebhook(['url' => 'https://weathercast.ru/telegram/webhook']);
    }
}
