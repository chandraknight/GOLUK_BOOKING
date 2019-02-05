<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlightBookingDetails extends Model
{
    protected $fillable = [
        'flight_booking_id','passenger_title','passenger_name','passenger_surname','passenger_gender','passenger_type','passenger_nationality',
        'passenger_remarks','currency','price','fuel_surcharge','tax','pnr','ticket','barcode','sector',
        'airline','flight_no','flight_date','flight_time','class','refundable','commission'
    ];

    public function booking(){
        return $this -> belongsTo('App\FlightBooking');
    }
}
