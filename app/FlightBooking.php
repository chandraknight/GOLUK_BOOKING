<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlightBooking extends Model
{
    protected $fillable= [
        'search_flight_id',
        'customer_name',
        'customer_contact',
        'customer_email',
        'adults',
        'childs',
        'amount',
        'currency',
        'user_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function search(){
        return $this->belongsTo('App\SearchFlight');
    }

    public function details(){
        return $this->hasMany('App\FlightBookingDetails');
    }

    public function getPnrs(){
        return $this->hasMany('App\FlightPnr');
    }

    public function getTickets(){
        return $this->hasMany('App\FlightTicket');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
