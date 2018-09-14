<?php

namespace App\Listeners\Booking;

use App\Events\Booking\BookConfirmSendMailEvent;
use App\Mail\Booking\RoomBookedMailCustomer;
use Illuminate\Support\Facades\Mail;

class BookConfirmSendMailListener
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
     * @param  BookConfirmSendMailEvent  $event
     * @return void
     */
    public function handle(BookConfirmSendMailEvent $event)
    {
        Mail::to($event->booking['customer_email'])->send(new RoomBookedMailCustomer($event->booking,$event->hotel));
    }
}
