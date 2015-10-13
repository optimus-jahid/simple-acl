<?php

namespace SimpleAcl\Repositories;

use SimpleAcl\Models\Permission;
use SimpleAcl\Models\PermissionDependency;

class PermissionRepository
{
	
	/**
	 * @var RoleRepository
	 */
	protected $roles;

	/**
	 * @var PermissionDependencyRepository
     */
	protected $dependencies;

	/**
	 * @param RoleRepository $roles
	 * @param void
     */
	public function __construct() {
		$this->roles = new RoleRepository;
		$this->dependencies = new PermissionDependencyRepository;
	}

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
	 * @throws Exception
	 */
	public function findOrThrowException($id, $withRoles = false) {
		if (! is_null(Permission::find($id))) {
			if ($withRoles)
				return Permission::with('roles')->find($id);

			return Permission::find($id);
		}

		throw new Exception('That permission does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getPermissionsPaginated($per_page, $order_by = 'display_name', $sort = 'asc') {
		return Permission::with('roles')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @param bool $withRoles
	 * @return mixed
	 */
	public function getAllPermissions($order_by = 'display_name', $sort = 'asc', $withRoles = true) {
		if ($withRoles)
			return Permission::with('roles', 'dependencies.permission')->orderBy($order_by, $sort)->get();

		return Permission::with('dependencies.permission')->orderBy($order_by, $sort)->get();
	}

	/**
	 * @return mixed
     */
	public function getUngroupedPermissions() {
		return Permission::whereNull('group_id')
			->orderBy('display_name', 'asc')
			->get();
	}

	/**
	 * @param $input
	 * @param $roles
	 * @return bool
	 * @throws Exception
	 */
	public function create($input, $roles=[]) {
		$permission = new Permission;
		$permission->name = $input['name'];
		$permission->display_name = $input['display_name'];
		$permission->system = isset($input['system']) ? 1 : 0;
		$permission->group_id = isset($input['group']) && strlen($input['group']) > 0 ? (int)$input['group'] : null;
		$permission->sort = isset($input['sort']) ? (int)$input['sort'] : 0;

		if ($permission->save()) {
			//Add the dependencies of this permission if any
			if (isset($input['dependencies']) && count($input['dependencies']))
				foreach ($input['dependencies'] as $dependency_id)
					$this->dependencies->create($permission->id, $dependency_id);

			return true;
		}

		throw new \Exception("There was a problem creating this permission. Please try again.");
	}

	/**
	 * @param $id
	 * @param $input
	 * @return bool
	 * @throws Exception
	 */
	public function update($id, $input) {
		$permission = $this->findOrThrowException($id);
		$permission->name = $input['name'];
		$permission->display_name = $input['display_name'];
		$permission->system = isset($input['system']) ? 1 : 0;
		$permission->group_id = isset($input['group']) && strlen($input['group']) > 0 ? (int)$input['group'] : null;
		$permission->sort = isset($input['sort']) ? (int)$input['sort'] : 0;

		if ($permission->save()) {
			return true;
		}

		throw new \Exception("There was a problem updating this permission. Please try again.");
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws Exception
	 */
	public function destroy($id) {
		$permission = $this->findOrThrowException($id);

		if ($permission->system == 1)
			throw new Exception("You can not delete a system permission.");

		//Remove the permission from all associated roles
		$currentRoles = $permission->roles;
		foreach ($currentRoles as $role) {
			$role->detachPermission($permission);
		}

		//Remove the permission from all associated users
		$currentUsers = $permission->users;
		foreach ($currentUsers as $user) {
			$user->detachPermission($permission);
		}

		//Remove the dependencies
		$permission->dependencies()->delete();

		if ($permission->delete())
			return true;

		throw new Exception("There was a problem deleting this permission. Please try again.");
	}
}