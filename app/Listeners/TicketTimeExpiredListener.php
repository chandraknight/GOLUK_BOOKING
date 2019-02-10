<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\TicketTimeExpiredEvent;

class TicketTimeExpiredListener implements ShouldQueue
{
    use InteractsWithQueue;
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
    public function handle(TicketTimeExpiredEvent $event)
    {   
        $this->release(30);
        session()->flush();
        return redirect()->route('welcome')->with('error','Ticket Time Expired');
    }
}
