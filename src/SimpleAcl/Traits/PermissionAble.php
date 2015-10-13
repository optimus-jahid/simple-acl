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

	function updatePermission($perm_id, $params)
	{
		$repository = new PermissionRepository;
		return $repository->update($perm_id, $params);	
	}

	function deletePermission($ability)
	{

	}

	function allPermissions($filters)
	{

	}

}
