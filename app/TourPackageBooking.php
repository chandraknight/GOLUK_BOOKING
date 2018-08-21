<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourPackageBooking extends Model
{
    protected $fillable = [
        'tour_package_id',
        'no_of_people',
        'starting_from',
        'till_date',
        'booking_status',
        'customer_name',
        'customer_address',
        'customer_email',
        'customer_contact',
        'user_id'
    ];

    public function tourPackage() {
        return $this -> belongsTo('App\TourPackage','tour_package_id');
    }
    public function bookingDetails() {
        return $this -> hasMany('App\TourPackageBookingDetails');
    }

    public function invoices() {
        return $this -> hasOne('App\TourBookedInvoice','tour_package_booking_id');
    }

    public function bookingCommission() {
        return $this -> hasOne('App\TourBookingCommission','tour_package_booking_id');
    }

    public function agentTourBookingCommission() {
        return $this -> hasOne('App\AgentTourPackageBookingCommission');
    }

    public function user() {
        return $this -> belongsTo('App\User');
    }
}
