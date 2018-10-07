<?php

namespace App\Notifications;

use App\User;
use App\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VehicleRegisteredNotification extends Notification
{
    use Queueable;
    public $vehicle,$user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Vehicle $vehicle, User $user)
    {
        $this->vehicle = $vehicle;
        $this->user = $user;
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

    public function toDatabase() {
        return [
            'data'=>$this->user->name
            .' has registered new '.
            $this->vehicle->name
            .' vehicle ',
            'vehicle_id'=>$this->vehicle->id
        ];
    }
}
