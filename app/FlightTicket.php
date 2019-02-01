<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlightTicket extends Model
{
    protected $fillable = [
        'flight_booking_id','flight_pnr_id','ticket'
    ];
    protected  $dates = [
        'created_at','updated_at','ticket_date'
    ];

    public function flightBooking(){
        return $this->belongsTo('App\FlightBooking');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function pnr(){
        return $this->belongsTo('App\FlightPnr');
    }
}
