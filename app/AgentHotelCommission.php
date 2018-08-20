<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentHotelCommission extends Model
{
    protected $fillable = [
    	'user_id',
    	'hotel_id',
    	'commission_percent'
    ];

    public function hotel() {
    	return $this->belongsTo('App\Hotel');
    }
}
