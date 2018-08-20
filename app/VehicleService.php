<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleService extends Model
{
    protected $fillable =[
        'service_name',
        'service_description'
    ];

    public function vehicles(){
        return $this->belongsToMany('App\Vehicle');
    }

    public function vehicleServiceCost(){
        return $this -> hasMany('App\VehicleServiceCost','vehicle_service_id');
    }

    public function bookingDetails() {
        return $this -> belongsToMany('App\VehicleBookingDetails');
    }
}
