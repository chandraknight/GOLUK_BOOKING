<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'payment_status'
];

    public function booking() {
        return $this -> belongsTo('App\Booking','booking_id');
    }
}
