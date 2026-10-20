<?php

namespace App\Observers;
use App\Models\Earthquake;
use Illuminate\Support\Facades\Log;

class EarthquakeObserver
{
    /**
     * Handle the Earthquake "created" event.
     */
    public function created(Earthquake $earthquake): void
    {
        Log::info('New earthquake recorded',[
            'location' => $earthquake->location,
            'magnitude' => $earthquake->magnitude,
            'occured_at' => $earthquake->occured_at,
        ]);
        event(new \App\Events\EarthquakeCreated($earthquake));
    }

    /**
     * Handle the Earthquake "updated" event.
     */
    public function updated(Earthquake $earthquake): void
    {
        Log::info('earthquake updated', [
            'location' => $earthquake->location,
            'magnitude' => $earthquake->magnitude,
            'occured_at' => $earthquake->occured_at,
        ]);
    }

    /**
     * Handle the Earthquake "deleted" event.
     */
    public function deleted(Earthquake $earthquake): void
    {
        //
    }

    /**
     * Handle the Earthquake "restored" event.
     */
    public function restored(Earthquake $earthquake): void
    {
        //
    }

    /**
     * Handle the Earthquake "force deleted" event.
     */
    public function forceDeleted(Earthquake $earthquake): void
    {
        //
    }
}
