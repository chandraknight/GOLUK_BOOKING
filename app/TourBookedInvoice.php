<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourBookedInvoice extends Model
{
    protected $function = [
        'tour_package_booking_id',
        'pricing',
        'rate',
        'amount'
    ];

    public function booking() {
        return $this -> belongsTo('App\TourPackageBooking');
    }
}
