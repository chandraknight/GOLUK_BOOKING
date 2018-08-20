<?php

namespace App\Mail\Booking;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TourBookedConfirm extends Mailable
{
    use Queueable, SerializesModels;
    public $booking,$tour;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TourPackageBooking $booking,TourPackage $tour)
    {
        return $this->booking = $booking;
        return $this->tour = $tour;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.booking.tourbookedconfirm');
    }
}
