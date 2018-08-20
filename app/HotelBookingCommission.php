<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelBookingCommission extends Model
{
    protected $fillable = [
    	'hotel_booking_id',
    	'commission_percent',
    	'commission'
    ];

    public function hotelBooking() {
    	return $this -> belongsTo('App\Booking');
    }
}
