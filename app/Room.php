<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'hotel_id',
        'room_flat_cost',
        'room_type',
        'room_no',
        'no_of_rooms',
        'no_adults',
        'no_childs',
        'no_beds',
        'max_add_beds',
        'cost_per_add_bed',
        'cost_ap_plan',
        'cost_ep_plan',
        'cost_cp_plan',
        'cost_map_plan',
        'user_id',
        'last_updated_by',
        'image'
    ];

    public function roomgallery()
    {
        return $this->hasMany('App\RoomGallery');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }

    public function bookRoom()
    {
        return $this->belongsTo('App\BookedRoom', 'room_id');
    }

    public function roomservices()
    {
        return $this->belongsToMany('App\RoomService');
    }

    public function roomType()
    {
        return $this->belongsTo('App\RoomType', 'room_type_id');
    }
}
