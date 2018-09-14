<?php

namespace App\Events\Booking;

use App\VehicleBooking;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VehicleBookingCanceledEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $booking;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VehicleBooking $booking)
    {
        $this->booking = $booking;
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
