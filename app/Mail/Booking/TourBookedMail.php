<?php

namespace App\Mail\Booking;

use App\TourPackage;
use App\TourPackageBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TourBookedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking,$tour;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TourPackageBooking $booking, TourPackage $tour)
    {
        $this->booking = $booking;
        $this->tour = $tour;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.booking.tourbookedowner');
    }
}
