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
//        $result = $weather->getByCoords('10.99', '44.34');
//        $result = $weather->getCoordsByCity('Москва');
        $result = $weather->getByCity('Москва');
        dd($result);
    }
}
