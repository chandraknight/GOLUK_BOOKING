<?php

namespace App\Events\Booking;

use App\Booking;
use App\Hotel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BookConfirmSendMailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $hotel,$booking;

    /**
     * Create a new event instance.
     *
     * @param Hotel $hotel
     * @param Booking $booking
     */
    public function __construct(Hotel $hotel,Booking $booking)
    {
        $this->booking = $booking;
        $this->hotel = $hotel;
    }


}
