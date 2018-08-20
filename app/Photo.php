<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
    	'title',
    	'description',
    	'photo'
    ];

    public function hotel() {
    	return $this -> belongsTo('App\Hotel');
    }

}
