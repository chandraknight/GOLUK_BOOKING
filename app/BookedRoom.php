<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookedRoom extends Model
{
    protected $table = 'booked_room_details';

    protected $fillable = [
        'booking_id',
        'room_id',
        'room_type',
        'plan',
        'rate',
        'no_of_rooms'
    ];

    public function book() {
        return $this -> belongsTo('App\Booking','booking_id');
    }

    public function rooms() {
        return $this -> belongsTo('App\Room','room_id');
    }
}
