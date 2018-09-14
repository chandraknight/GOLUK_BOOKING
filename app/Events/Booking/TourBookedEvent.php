<?php

namespace App\Events\Booking;

use App\TourPackage;
use App\TourPackageBooking;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TourBookedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking,$tour,$user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TourPackageBooking $booking, TourPackage $tour,User $user)
    {
        $this->booking = $booking;
        $this->tour = $tour;
        $this->user = $user;
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
