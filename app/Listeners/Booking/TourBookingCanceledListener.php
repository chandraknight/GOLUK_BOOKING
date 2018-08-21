<?php

namespace App\Listeners\Booking;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Booking\TourBookingCanceledEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\Booking\TourBookingCanceledMail;

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
