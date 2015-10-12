<?php
namespace SimpleAcl\Traits;

use SimpleAcl\Repositories\UserRepository;

trait AssignAble
{
	function attachUserRole($roles, $user)
	{
		$repository = new UserRepository;

		if( empty($roles) || empty($user))
			return false;

		return $repository->attachRoles($roles, $user);
	}

	function attachUserPermission($abilities, $user)
	{

	}

	function detachUserPermission($abilities, $user)
	{

	}

	function attachRolePermission($abilities, $user)
	{

	}

	function detachRolePermission($abilities, $user)
	{

	}
}