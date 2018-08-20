<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourPackageBookingDetails extends Model
{
    protected $fillable = [
        'name',
        'address',
        'dob',
        'gender',
        'contact'
    ];

    public function tourBooking() {
        return $this -> belongsTo('App\TourPackageBooking');
    }
}
