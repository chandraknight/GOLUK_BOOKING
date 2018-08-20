<?php

namespace App\Events\Booking;

use App\Vehicle;
use App\VehicleBooking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VehicleBookingConfirmEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $booking, $vehicle;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VehicleBooking $booking, Vehicle $vehicle)
    {
        $this->booking = $booking;
        $this->vehicle = $vehicle;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
