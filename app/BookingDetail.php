<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $fillable = [
        'booking_id',
        'guest_name',
        'date_of_birth',
        'address',
        'gender',
        'adult_child',
        'remarks',
    ];

    public function booking(){
        return $this -> belongsTo('App\Booking');
    }

}
