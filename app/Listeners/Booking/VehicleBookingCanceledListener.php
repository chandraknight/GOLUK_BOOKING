<?php

namespace App\Listeners\Booking;

use App\Events\Booking\VehicleBookingCanceledEvent;
use App\Mail\Booking\VehicleBookingCanceledMail;
use Illuminate\Support\Facades\Mail;

class VehicleBookingCanceledListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(VehicleBookingCanceledEvent $event)
    {
        Mail::to($event->booking['customer_email'])->send(new VehicleBookingCanceledMail($event->booking));
    }
}
