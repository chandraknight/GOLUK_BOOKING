<?php

namespace App\Listeners\Booking;

use App\Events\Booking\VehicleBookingMailOwnerEvent;
use App\Mail\Booking\VehicleBookedOwnerMail;
use Illuminate\Support\Facades\Mail;

class VehicleBookingMailOwnerListener
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
    public function handle(VehicleBookingMailOwnerEvent $event)
    {
        Mail::to($event->user)->send(new VehicleBookedOwnerMail($event->vehicle, $event->vehiclebooking));
    }
}
