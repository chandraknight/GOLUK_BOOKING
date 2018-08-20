<?php

namespace App\Notifications;

use App\Vehicle;
use App\VehicleBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VehicleBooked extends Notification
{
    use Queueable;
    public $vehicle,$vehiclebooking;

    /**
     * Create a new notification instance.
     *
     * @param Vehicle $vehicle
     * @param VehicleBooking $vehiclebooking
     */
    public function __construct(Vehicle $vehicle,VehicleBooking $vehiclebooking)
    {
        $this->vehicle = $vehicle;
        $this->vehiclebooking = $vehiclebooking;
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
            'data'=> $this->vehiclebooking->customer_name
                .' has booked your '.
                $this->vehicle->name
                .' from '.
                $this->vehiclebooking->from
                .' to '.
                $this->vehiclebooking->to
                .'.',
            'booking_id'=>$this->vehiclebooking->id
        ];
    }
}
