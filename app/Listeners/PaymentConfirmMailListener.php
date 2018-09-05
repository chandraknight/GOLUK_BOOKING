<?php

namespace App\Listeners;

use App\Events\PaymentConfirmMailEvent;
use App\Mail\PaymentConfirmMail;

class PaymentConfirmMailListener
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
    public function handle(PaymentConfirmMailEvent $event)
    {
        Mail::to($event->booking['customer_email'])->send(new PaymentConfirmMail($event->booking));
    }
}
