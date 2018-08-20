<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentHotelBookingCommission extends Model
{
    protected $fillable = [
    	'booking_id',
    	'user_id',
    	'hotel_commission_percent',
    	'agent_commission_percent',
    	'commission'
    ];

    public function booking() {
    	return $this->belongsTo('App\Booking');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }
}
