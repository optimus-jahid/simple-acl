<?php

namespace SimpleAcl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {

	use SoftDeletes;

	public function roles()
    {
        return $this->belongsToMany('SimpleAcl\Models\Role', 'assigned_roles', 'user_id', 'role_id');
    }

}