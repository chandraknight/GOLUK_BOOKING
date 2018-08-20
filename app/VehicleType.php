<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $fillable = [
      'type_name',
      'type_description'
    ];

    public function vehicle(){
        return $this->hasMany('App\Vehicle');
    }
}
