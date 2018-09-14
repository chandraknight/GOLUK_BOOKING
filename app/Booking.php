<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_email',
        'hotel',
        'no_rooms',
        'no_adults',
        'no_childs',
        'from_date',
        'till_date',
        'status',
    ];

    public function bookingDetails() {
        return $this -> hasMany('App\BookingDetail');
    }

    public function bookedRoom(){
        return $this -> hasMany('App\BookedRoom');
    }

    public function hotel(){
        return $this -> belongsTo('App\Hotel','hotel_id');
    }

    public function invoice() {
        return $this -> hasOne('App\Invoice');
    }

    public function bookingCommission() {
        return $this -> hasOne('App\HotelBookingCommission','hotel_booking_id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function agentCommission() {
        return $this -> hasOne('App\AgentHotelBookingCommission');
    }
}
