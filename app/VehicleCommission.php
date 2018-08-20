<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCommission extends Model
{
    protected $fillable = [
    	'vehicle_id',
    	'commission_percent'
    ];

    public function vehicle() {
    	return $this -> belongsTo('App\Vehicle');
    }
}
