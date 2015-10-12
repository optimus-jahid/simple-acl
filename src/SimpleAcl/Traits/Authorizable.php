<?php

namespace SimpleAcl\Traits;

use SimpleAcl\Repositories\UserRepository;

trait Authorizable
{
    use AssignAble, PermissionAble, RoleAble;
    
    function hasRoles($roles, $user, $needsAll = false)
	{
		$repository = new UserRepository;
		return $repository->hasRoles($roles, $user, $needsAll);
	}

	function hasRole($role, $user)
	{
		$repository = new UserRepository;
		return $repository->hasRole($role, $user);
	}

	function hasPermission($ability, $user)
	{
		$repository = new UserRepository;
		return $repository->hasPermission($ability, $user);
	}	
}