<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleBookingDetails extends Model
{
    protected  $fillable =[
      'vehicle_booking_id',
        'vehicle_service_id',
        'vehicle_service_cost',
    ];

    public function vehicleBooking() {
        return $this -> belongsTo('App\VehicleBooking');
    }

    public function vehicleService() {
        return $this -> belongsTo('App\VehicleService');
    }
}
