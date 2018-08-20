<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomGallery extends Model
{
    protected $fillable = [
        'room_id',
        'image'
    ];

    public function rooms() {
        return $this -> belongsTo('App\Room');
    }
}
