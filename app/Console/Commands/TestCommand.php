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
        $this->info('Check weather');

        try {
            $result = $weather->getByCity('Иваново');
            dd($result);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

    }
}
