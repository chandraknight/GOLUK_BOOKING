<?php

namespace App\Notifications;

use App\Booking;
use App\Hotel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RoomBooked extends Notification
{
    use Queueable;
    public $hotel,$booking;

    /**
     * Create a new notification instance.
     *
     * @param Hotel $hotel
     * @param Booking $booking
     */
    public function __construct(Hotel $hotel,Booking $booking)
    {
         $this->hotel = $hotel;
         $this->booking=$booking;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function toDatabase(){

        return [
          'data' => $this->booking->customer_name.' has booked '.$this->booking->no_rooms.
              ' rooms on hotel '.$this->hotel->name.' for '.$this->booking->from_date.
              ' to '.$this->booking->till_date.'.',
            'booking_id'=>$this->booking->id
        ];
    }
}
