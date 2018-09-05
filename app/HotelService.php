<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class HotelService extends Model
{
    protected $fillable = [
    	'service_name',
    	'service_time',
    	'service_type',
    	'service_cost',
    	'service_cost_unit',
    	'service_description',
    	'service_remarks',
    	'service_enable',
    ];

    public function hotels() {
        return $this -> belongsToMany('App\Hotel');
    }
}
