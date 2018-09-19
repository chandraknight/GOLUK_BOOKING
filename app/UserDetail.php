<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'contact',
        'image',
        'citizenship',
        'business_certificate',
        'owner_name',
        'business_logo',
        'business_type',
    ];

    public function user() {
        return $this -> belongsTo('App\User');
    }
}
