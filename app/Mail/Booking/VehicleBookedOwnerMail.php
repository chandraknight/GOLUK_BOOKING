<?php

namespace App\Mail\Booking;

use App\Vehicle;
use App\VehicleBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VehicleBookedOwnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vehicle,$vehiclebooking;

    /**
     * Create a new message instance.
     *
     * @param Vehicle $vehicle
     * @param VehicleBooking $vehiclebooking
     */
    public function __construct(Vehicle $vehicle,VehicleBooking $vehiclebooking)
    {
        $this->vehicle = $vehicle;
        $this->vehiclebooking = $vehiclebooking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.booking.vehiclebookownermail');
    }
}
