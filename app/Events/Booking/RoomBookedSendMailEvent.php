<?php

namespace App\Events\Booking;

use App\Booking;
use App\Hotel;
use App\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomBookedSendMailEvent
{
    use Dispatchable, SerializesModels;

    public $booking, $hotel, $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Hotel $hotel
     * @param Booking $booking
     */
    public function __construct(Booking $booking,Hotel $hotel,User $user)
    {
        $this->user = $user;
        $this->hotel = $hotel;
        $this->booking = $booking;
    }
}
