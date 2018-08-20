<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourSearch extends Model
{
    protected $fillable = [
        'destination',
        'from',
        'location',
        'people'
    ];
}
