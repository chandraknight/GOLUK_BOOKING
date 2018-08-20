<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourPackageCommission extends Model
{
    protected $fillable = [
    	'tour_package_id',
    	'commission_percent'
    ];

    public function tourPackage() {
    	return $this -> belongsTo('App\TourPackage');
    }
}
