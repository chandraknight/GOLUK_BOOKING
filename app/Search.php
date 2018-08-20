<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = [
        'destination',
        'from_date',
        'to_date',
        'no_adults',
        'no_childs',
    ];
}
