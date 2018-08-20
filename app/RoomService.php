<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomService extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public  function rooms()
    {
        return $this -> belongsToMany('App\Room');
    }

    public function hotel(){
        return $this->belongsTo('App\Hotel');
    }
}
