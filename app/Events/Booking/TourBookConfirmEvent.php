<?php

namespace App\Events\Booking;

use App\TourPackage;
use App\TourPackageBooking;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TourBookConfirmEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking,$tour;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TourPackageBooking $booking,TourPackage $tour)
    {
        $this->booking = $booking;
        $this->tour = $tour;
    }

    
}
