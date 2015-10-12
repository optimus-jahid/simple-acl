<?php
namespace SimpleAcl\Traits;

use SimpleAcl\Repositories\PermissionRepository;

trait PermissionAble
{
	function createPermission($params)
	{
		$repository = new PermissionRepository;
		return $repository->create($params);
	}

	function editPermission($ability)
	{

	}

	function deletePermission($ability)
	{

	}

	function allPermissions($filters)
	{

	}

}
