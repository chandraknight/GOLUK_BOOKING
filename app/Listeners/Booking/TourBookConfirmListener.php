<?php

namespace App\Listeners\Booking;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Booking\TourBookConfirmEvent;
use App\Mail\Booking\TourBookedConfirm;

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
        Mail::to($event->booking['customer_email'])->send(new TourBookedMailCustomer($event->booking,$event->hotel));
    }
}
