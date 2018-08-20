<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleBookingCommission extends Model
{
    protected $fillable = [
    	'vehicle_booking_id',
    	'total_amount',
    	'commission_percent',
    	'commission'
    ];

    public function vehicleBooking() {
    	return $this -> belongsTo('App\VehicleBooking');
    }
}
