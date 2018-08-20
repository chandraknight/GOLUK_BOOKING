<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentTourPackageBookingCommission extends Model
{
   protected $fillable = [
    	'user_id',
    	'tour_package_booking_id',
    	'tour_package_commission_percent',
    	'agent_commission_percent',
    	'commission'
   ];

   public function tourpackageBooking() {
   	return $this->belongsTo('App\TourPackageBooking');
   }

   public function user() {
   	return $this -> belongsTo('App\User');
   }
}
