<?php

namespace App\Service\Parcel\Events;

use App\Models\Parcel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParcelRegistered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Parcel $parcel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Parcel $parcel)
    {
        $this->parcel = $parcel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('drivers');
    }

    /**
     * The event's broadcast name.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return $this->parcel->toArray();
    }

    public function broadcastAs () {
        return 'parcel-registered';
    }
}
