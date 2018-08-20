<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourGallery extends Model
{
    protected $fillable = [
        'image',
        'tour_package_id'
    ];

    public function tourPackage() {
        return $this -> belongsTo('App\tourPackage');
    }
}
