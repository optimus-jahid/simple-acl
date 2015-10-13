<?php

namespace SimpleAcl\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
	/**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('SimpleAcl\Models\User', 'permission_user', 'permission_id', 'user_id');
    }
}