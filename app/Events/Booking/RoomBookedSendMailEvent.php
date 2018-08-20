<?php

namespace App\Events\Booking;

use App\BookedRoom;
use App\Booking;
use App\BookingDetail;
use App\Hotel;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

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
