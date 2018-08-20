<?php

namespace App;
use App\User;
use App\HotelService;
use App\FullTextSearch;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{

  use FullTextSearch;
    protected $fillable = [
   		'email',
   		'name',
        'website',
   		'logo',
   		'address',
   		'no_rooms',
   		'contact',
   		'agent_name',
   		'agent_contact',
   		'check_out_time',
         'created_by',
         'last_updated_by',
        'flag',
        'hotel_code'
   ];

   protected $searchable = [
      'name',
      'address',

   ];

   public function user() {
   	return $this->belongsTo('App\User','created_by');
   }

   public function hotelservices() {
      return $this -> belongsToMany('App\HotelService');
   }
   public function photos(){
      return $this -> hasMany('App\Photo');
   }
   public function rooms() {
       return $this -> hasMany('App\Room');
   }
   public function bookHotel() {
       return $this -> hasMany('App\Booking');
   }

    public function roomTypes() {
       return $this -> hasMany('App\RoomType');
    }

   public function roomservices(){
       return $this -> hasMany('App\RoomService');
   }

   public function hotelCommission() {
    return $this -> hasOne('App\HotelCommission','hotel_id');
   }

   public function agnetHotelCommission() {
    return $this -> belongsToMany('App\AgentHotelCommission');
   }
}
