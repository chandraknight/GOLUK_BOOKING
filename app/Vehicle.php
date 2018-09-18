<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'contact',
        'email',
        'type',
        'no_of_people',
        'rate_per_day',
        'sit_pattern',
        'user_id',
        'fuel',
        'gear',
        'drive_train',
        'gps',
        'image',
        'flag',
        'vehicle_code'
    ];

    public function user(){
        return $this -> belongsTo('App\User');
    }

    public function services() {
        return $this->belongsToMany('App\VehicleService');
    }

    public function types() {
        return $this ->belongsTo('App\VehicleType','type');
    }

    public function vehicleServiceCost() {
        return $this -> hasMany('App\VehicleServiceCost','vehicle_id');
    }

    public function vehicleCommission() {
        return $this -> hasOne('App\VehicleCommission');
    }

    public function agentVehicleCommission() {
        return $this->belongsToMany('App\AgentVehicleCommission');
    }
}
