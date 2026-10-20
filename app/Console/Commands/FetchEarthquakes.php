<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Services\EarthquakeService;

#[Signature('app:fetch-earthquakes')]
#[Description('Command description')]
class FetchEarthquakes extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(EarthquakeService $service)
    {
        $count = $service->dataPoints();
        $this->info('Successfully processed {$count} earthquakes.');
    }
}
