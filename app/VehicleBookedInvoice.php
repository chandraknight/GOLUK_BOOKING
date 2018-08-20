<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleBookedInvoice extends Model
{
    protected $fillable = [
        'vehicle_id',
        'vehicle_booking_id',
        'rate',
        'cost'
    ];

    

    public function vehicleBooking() {
        return $this->belongsTo('App\VehicleBooking','vehicle_booking_id');
    }
}
