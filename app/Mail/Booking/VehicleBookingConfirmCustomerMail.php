<?php

namespace App\Mail\Booking;

use App\Vehicle;
use App\VehicleBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VehicleBookingConfirmCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking,$vehicle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VehicleBooking $booking, Vehicle $vehicle)
    {
        $this->booking = $booking;
        $this->vehicle = $vehicle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.booking.vehiclebookconfirm');
    }
}
