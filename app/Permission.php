<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function roles(){
        return $this -> belongsToMany('App\Permission','roles_permissions');
    }

    public function users(){
        return $this -> belongsToMany('App\User','users_permissions');
    }
}
