<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchFlight extends Model
{
    protected $fillable = [
        'location','destination','depart_date','return_date','childs','adults','nationality'
    ];

    protected $dates = [
        'created_at','updated_at','depart_date','return_date'
    ];

    public function isBooked(){
        return $this->hasOne('App\FlightBooking');
    }

    public function hasPnr(){
        return $this->hasMany('App\FlightPnr');
    }
}
