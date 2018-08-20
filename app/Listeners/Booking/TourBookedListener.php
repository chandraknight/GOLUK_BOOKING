<?php

namespace App\Listeners\Booking;

use App\Events\Booking\TourBookedEvent;
use App\Mail\Booking\TourBookedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class TourBookedListener
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
    public function handle(TourBookedEvent $event)
    {
        Mail::to($event->user)->send(new TourBookedMail($event->booking,$event->tour));
    }
}
