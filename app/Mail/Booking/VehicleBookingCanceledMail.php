<?php

namespace App\Mail\Booking;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\VehicleBooking;

class VehicleBookingCanceledMail extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VehicleBooking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.booking.vehiclebookingcancel');
    }
}
