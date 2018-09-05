<?php

namespace App\Events\Booking;

use App\User;
use App\Vehicle;
use App\VehicleBooking;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VehicleBookingMailOwnerEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vehiclebooking,$vehicle,$user;

    /**
     * Create a new event instance.
     *
     * @param VehicleBooking $vehiclebooking
     * @param Vehicle $vehicle
     * @param User $user
     */
    public function __construct(VehicleBooking $vehiclebooking, Vehicle $vehicle, User $user)
    {
        $this->vehiclebooking = $vehiclebooking;
        $this->vehicle = $vehicle;
        $this->user = $user;
    }


}
