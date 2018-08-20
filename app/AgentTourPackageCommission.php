<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentTourPackageCommission extends Model
{
    protected $fillable = [
    	'user_id',
    	'tour_package_id',
    	'commission_percent'
    ];

    public function tourPackage() {
    	return $this->belongsTo('App\TourPackage');
    }
}
