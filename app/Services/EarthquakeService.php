<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Earthquake;
use Carbon\Carbon;

class EarthquakeService
{
    public function dataPoints()
    {

        $response = Http::get('https://earthquake.usgs.gov/fdsnws/event/1/query', [
            'format' => 'geojson',
            'limit' => 50,
            'orderby' => 'time',
            'minmagnitude' => 2.5
        ]);

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data['features'] as $quake) {
                Earthquake::updateOrCreate(
                    ['usgs_id' => $quake['id']],
                    [
                        'magnitude' => $quake['properties']['mag'],
                        'location' => $quake['properties']['place'],
                        'occured_at' => Carbon::createFromTimeStampMs($quake['properties']['time']),
                    ]
                );
            }
            return count($data['features']);
        }

        return 0;

    }
}
