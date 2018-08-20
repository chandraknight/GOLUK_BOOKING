<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourBookingCommission extends Model
{
    protected $fillable = [
    	'tour_package_booking_id',
    	'commission_percent',
    	'commission'
    ];

    public function tourBooking() {
    	return $this -> belongsTo('App\TourPackageBooking');
    }
}
