<?php

namespace App\Listeners\Booking;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Booking\FlightBookedEvent;
use App\Mail\Booking\FlightBookedMail;
use Illuminate\Support\Facades\Mail;

class FlightBookedEventListener
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
    public function handle(FlightBookedEvent $event)
    {
        Mail::to($event->booking['customer_email'])->send(new FlightBookedMail($event->booking));
    }
}
