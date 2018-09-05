<?php

namespace App\Listeners\Booking;

use App\Events\Booking\TourBookConfirmEvent;
use App\Mail\Booking\TourBookedConfirm;
use Illuminate\Support\Facades\Mail;

class TourBookConfirmListener
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
    public function handle(TourBookConfirmEvent $event)
    {
        Mail::to($event->booking['customer_email'])->send(new TourBookedConfirm($event->booking,$event->tour));
    }
}
