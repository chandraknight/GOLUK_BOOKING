<?php

namespace App;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable,HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hotel()
    {
        return $this->hasMany('App\Hotel');
    }

    public function vehicle() {
        return $this->hasMany('App\Vehicle');
    }

    public function tourPackage() {
        return $this->hasMany('App\TourPackage');
    }

    public function hotelBooking() {
        return $this->hasMany('App\Booking');
    }

    public function vehicleBooking() {
        return $this -> hasMany('App\VehicleBooking');
    }

    public function tourPackageBooking() {
        return $this->hasMany('App\TourPackageBooking');
    }

    public function agentHotelCommission() {
        return $this->hasMany('App\AgentHotelCommission');
    }

    public function agentVehicleCommission() {
        return $this->hasMany('App\AgentVehicleCommission');
    }

    public function agentTourPackageCommission() {
        return $this -> hasMany('App\AgentTourPackageCommission');
    }

    public function agnetHotelBookingCommission() {
        return $this -> hasMany('App\AgentHotelBookingCommission');
    }

    public function agentVehicleBookingCommission() {
        return $this -> hasMany('App\AgentVehicleBookingCommission');
    }

    public function agentTourPackageBookingCommission() {
        return $this->hasMany('App\AgentTourPackageBookingCommission');
    }

}
