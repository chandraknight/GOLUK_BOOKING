<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleServiceCost extends Model
{
    protected $fillable = [
      'vehicle_id',
      'vehicle_service_id',
      'cost_per_day'
    ];

    public function vehicle() {
        return $this -> belongsTo('App\Vehicle');
    }

    public function vehicleService() {
        return $this -> belongsTo('App\VehicleService');
    }
}
