<?php

namespace App\Notifications;

use App\TourPackage;
use App\TourPackageBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TourBookedNotification extends Notification
{
    use Queueable;
    public $booking,$tour;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TourPackageBooking $booking, TourPackage $tour)
    {
        $this->booking = $booking;
        $this->tour = $tour;
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
            //
        ];
    }

    public function toDatabase(){
        return [
          'data'=> $this->booking->customer_name
              .' has booked '.
              $this->tour->name
              .' tour for '.
              $this->booking->no_of_people
            .' from '.
              $this->booking->starting_from,
            'booking_id'=>$this->booking->id
        ];
    }
}
