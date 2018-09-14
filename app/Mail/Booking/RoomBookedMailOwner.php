<?php

namespace App\Mail\Booking;

use App\Booking;
use App\Hotel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoomBookedMailOwner extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $hotel, $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, Hotel $hotel)
    {
        $this->booking = $booking;
        $this->hotel = $hotel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.booking.hotelownermail');
    }
}
