<?php
namespace SimpleAcl\Traits;

use SimpleAcl\Repositories\RoleRepository;

trait RoleAble
{
	function  createRole($params)
	{
		$repository = new RoleRepository;
		return $repository->create($params);
	}

	function updateRole($role_id, $params)
	{
		$repository = new RoleRepository;
		return $repository->update($role_id, $params);
	}

	function deleteRole($role)
	{

	}

	

	function allRoles()
	{

	}

}