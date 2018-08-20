<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentVehicleBookingCommission extends Model
{
    protected $fillable = [
    	'user_id',
    	'vehicle_booking_id',
    	'vehicle_commission_percent',
    	'agent_commission_percent',
    	'commission'
   ];

   public function vehicleBooking() {
   	return $this->belongsTo('App\VehicleBooking');
   }

   public function user() {
   	return $this->belongsTo('App\User');
   }
}
