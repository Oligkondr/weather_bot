<?php

namespace App\Console\Commands;

use App\Services\Weather;
use Illuminate\Console\Command;

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
        $result = $weather->getByCoords('55.48', '37.56');
        dd($result);

    }
}
