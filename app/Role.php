<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function user() {
        return $this -> belongsToMany('App\User','roles_users');
    }

    public function permissions() {
        return $this -> belongsToMany('App\Permission','roles_permissions');
    }

    public function assign(Permission $permission) {
        return $this->permissions()->save($permission);
    }
}


