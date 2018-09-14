<?php

namespace App\Listeners\Booking;

use App\Events\Booking\RoomBookedSendMailEvent;
use App\Mail\Booking\RoomBookedMailOwner;
use Illuminate\Support\Facades\Mail;

class RoomBookedSendMailListener
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
     * @param  RoomBookedSendMailEvent  $event
     * @return void
     */
    public function handle(RoomBookedSendMailEvent $event)
    {
        Mail::to($event->user)->send(new RoomBookedMailOwner($event->booking,$event->hotel));
    }
}
