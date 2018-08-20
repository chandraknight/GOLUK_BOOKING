<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentVehicleCommission extends Model
{
    protected $fillable = [
    	'user_id',
    	'vehicle_id',
    	'commission_percent'
    ];

    public function vehicle() {
    	return $this->belongsTo('App\Vehicle');
    }
}
