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

	function editRole($role)
	{

	}

	function deleteRole($role)
	{

	}

	

	function allRoles()
	{

	}

}