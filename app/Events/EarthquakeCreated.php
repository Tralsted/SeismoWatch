<?php

namespace App\Events;

use App\Models\Earthquake;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EarthquakeCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Earthquake $earthquake)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('earthquakes'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'location' => $this->earthquake->location,
            'magnitude' => $this->earthquake->magnitude,
            'occured_at' => $this->earthquake->occured_at,
        ];

    }
}
