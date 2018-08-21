<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleBooking extends Model
{
    protected $fillable = [
        'vehicle_id',
        'location',
        'destination',
        'from',
        'to',
        'no_of_passenger',
        'booking_status',
        'customer_name',
        'customer_contact',
        'customer_address'
    ];

    public function bookingDetails()
    {
        return $this->hasMany('App\VehicleBookingDetails');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }

    public function invoice() 
    {
        return $this->hasOne('App\VehicleBookedInvoice');
    }

    public function bookingCommission() {
        return $this->hasOne('App\VehicleBookingCommission');
    }

    public function agentVehicleBookingCommission() {
        return $this->hasOne('App\AgentVehicleBookingCommission');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
