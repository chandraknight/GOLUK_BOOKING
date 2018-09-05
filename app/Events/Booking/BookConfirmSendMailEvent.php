<?php

namespace App\Events\Booking;

use App\Booking;
use App\Hotel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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
