<?php

namespace App\Listeners\Booking;

use App\Events\Booking\TourBookingCanceledEvent;
use App\Mail\Booking\TourBookingCanceledMail;
use Illuminate\Support\Facades\Mail;

class TourBookingCanceledListener
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
    public function handle(TourBookingCanceledEvent $event)
    {
        Mail::to($event->booking['customer_email'])->send(new TourBookingCanceledMail($event->booking));
    }
}
