<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlightPnr extends Model
{
    protected $fillable = [
        'flight_booking_id','airline_id','flight_id','pnr'
    ];

    protected $dates = [
        'created_at','updated_at'
    ];

    public function flightSearch(){
        return $this->belongsTo('App\SearchFlight');
    }

    public function booking(){
        return $this->belongsTo('App\FlightBooking');
    }

    public function getTickets(){
        return $this->hasMany('App\FlightTicket');
    }
}
