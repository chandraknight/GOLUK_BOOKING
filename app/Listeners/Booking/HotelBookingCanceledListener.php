<?php

namespace App\Listeners\Booking;

use App\Events\Booking\HotelBookingCanceledEvent;
use App\Mail\Booking\HotelBookingCanceledMail;
use Illuminate\Support\Facades\Mail;

class HotelBookingCanceledListener
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
    public function handle(HotelBookingCanceledEvent $event)
    {
        Mail::to($event->booking['customer_email'])->send(new HotelBookingCanceledMail($event->booking));
    }
}
