<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlightPnr extends Model
{
    protected $fillable = [
        'search_flight_id','pnr','type'
    ];

    protected $dates = [
        'created_at','updated_at'
    ];

    public function flightSearch(){
        return $this->belongsTo('App\SearchFlight');
    }

    public function getTickets(){
        return $this->hasMany('App\FlightTicket');
    }
}
