<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelCommission extends Model
{
    protected $fillable = [
    	'hotel_id',
    	'commission_percent'
    ];

    public function hotels() {
    	return $this -> belongsTo('App\Hotel');
    }
}
