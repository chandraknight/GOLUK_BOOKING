<?php

namespace App\Listeners\Booking;

use App\Events\Booking\VehicleBookingConfirmEvent;
use App\Mail\Booking\VehicleBookingConfirmCustomerMail;
use Illuminate\Support\Facades\Mail;

class VehicleBookingConfirmListener
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
    public function handle(VehicleBookingConfirmEvent $event)
    {

        Mail::to($event->booking['customer_email'])->send(new VehicleBookingConfirmCustomerMail($event->booking,$event->vehicle));
    }
}
