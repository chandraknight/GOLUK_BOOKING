<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleSearch extends Model
{
    protected $fillable = [
        'location',
        'destination',
        'from',
        'till',
        'passenger'
    ];
}
