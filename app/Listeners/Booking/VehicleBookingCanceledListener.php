<?php

namespace App\Listeners\Booking;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Booking\VehicleBookingCanceledMail;
use Illuminate\Support\Facades\Mail;
use App\Events\Booking\VehicleBookingCanceledEvent;

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
