<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Booking\RoomBookedSendMailEvent' =>
            ['App\Listeners\Booking\RoomBookedSendMailListener'],

        'App\Events\Booking\BookConfirmSendMailEvent' =>
            ['App\Listeners\Booking\BookConfirmSendMailListener'],

        'App\Events\PaymentConfirmMailEvent' =>
            ['App\Listeners\PaymentConfirmMailListener'],

        'App\Events\Booking\VehicleBookingMailOwnerEvent' =>
            ['App\Listeners\Booking\VehicleBookingMailOwnerListener'],

        'App\Events\Booking\VehicleBookingConfirmEvent' =>
            ['App\Listeners\Booking\VehicleBookingConfirmListener'],

        'App\Events\Booking\TourBookedEvent' =>
            ['App\Listeners\Booking\TourBookedListener'],

        'App\Events\Booking\TourBookConfirmEvent' =>
            ['App\Listeners\Booking\TourBookConfirmListener'],
        
        'App\Events\Booking\HotelBookingCanceledEvent' =>
        ['App\Listeners\Booking\HotelBookingCanceledListener'],
        
        'App\Events\Booking\VehicleBookingCanceledEvent' =>
        ['App\Listeners\Booking\VehicleBookingCanceledListener'],

        'App\Events\Booking\TourBookingCanceledEvent' =>
        ['App\Listeners\Booking\TourBookingCanceledListener']
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
