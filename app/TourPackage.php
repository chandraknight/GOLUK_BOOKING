<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'itenary',
        'info',
        'tag',
        'duration',
        'price',
        'group_price',
        'group_size',
        'user_id',
        'image',
        'flag',
        'tour_package_code'
    ];

    public function tourGallery() {
        return $this -> hasMany('App\TourGallery');
    }

    public function user() {
        return $this ->belongsTo('App\User');
    }

    public function tourPackageCommission() {
        return $this -> hasOne('App\TourPackageCommission');
    }

    public function agentTourCommission() {
        return $this->hasMany('App/AgentTourPackageCommission');
    }
}
