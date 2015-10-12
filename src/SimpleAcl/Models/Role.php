<?php

namespace SimpleAcl\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	/**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany('SimpleAcl\Models\Permission', 'permission_role', 'role_id', 'permission_id')
            ->orderBy('display_name', 'asc');
    }
}