<?php

namespace SimpleAcl\Repositories;

use SimpleAcl\Models\Role;

class RoleRepository
{
	/**
	 * @param $id
	 * @param bool $withPermissions
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
	 * @throws Exception
	 */
    public function findOrThrowException($id, $withPermissions = false) {
		if (! is_null(Role::find($id))) {
			if ($withPermissions)
				return Role::with('permissions')->find($id);

			return Role::find($id);
		}

		throw new Exception('That role does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getRolesPaginated($per_page, $order_by = 'sort', $sort = 'asc') {
		return Role::with('permissions')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @param bool $withPermissions
	 * @return mixed
	 */
	public function getAllRoles($order_by = 'sort', $sort = 'asc', $withPermissions = false) {
		if ($withPermissions)
			return Role::with('permissions')->orderBy($order_by, $sort)->get();

		return Role::orderBy($order_by, $sort)->get();
	}

	/**
	 * @param $input
	 * @return bool
	 * @throws Exception
	 */
	public function create($input) {
		if (Role::where('name', $input['name'])->first())
			throw new \Exception('That role already exists. Please choose a different name.');

		//See if the role has all access
		$all = $input['associated-permissions'] == "all" ? true : false;

		//This config is only required if all is false
		if (! $all)
			//See if the role must contain a permission as per config
			if (count($input['permissions']) == 0)
				throw new \Exception('You must select at least one permission for this role.');

		$role = new Role;
		$role->name = $input['name'];
		$role->sort = isset($input['sort']) && strlen($input['sort']) > 0 && is_numeric($input['sort']) ? (int)$input['sort'] : 0;

		//See if this role has all permissions and set the flag on the role
		$role->all = $all;

		if ($role->save()) {
			if (! $all) {
				$permissions = [];
				$current = explode(",", $input['permissions']);
				if (count($current)) {
					foreach ($current as $perm) {
						if (is_numeric($perm))
							array_push($permissions, $perm);
					}
				}
				$role->permissions()->attach($permissions);
			}

			return true;
		}

		throw new \Exception("There was a problem creating this role. Please try again.");
	}

	/**
	 * @param $id
	 * @param $input
	 * @return bool
	 * @throws Exception
	 */
	public function update($id, $input) {
		$role = $this->findOrThrowException($id);

		//See if the role has all access, administrator always has all access
		if ($role->id == 1)
			$all = true;
		else
			$all = $input['associated-permissions'] == "all" ? true : false;

		//This config is only required if all is false
		if (! $all)
			//See if the role must contain a permission as per config
			if (count($input['permissions']) == 0)
				throw new \Exception('You must select at least one permission for this role.');

		$role->name = $input['name'];
		$role->sort = isset($input['sort']) && strlen($input['sort']) > 0 && is_numeric($input['sort']) ? (int)$input['sort'] : 0;

		//See if this role has all permissions and set the flag on the role
		$role->all = $all;

		if ($role->save()) {
			//If role has all access detach all permissions because they're not needed
			if ($all)
				$role->permissions()->sync([]);
			else {
				//Remove all roles first
				$role->permissions()->sync([]);

				//Attach permissions if the role does not have all access
				$current = explode(",", $input['permissions']);
				$permissions = [];

				if (count($current)) {
					foreach ($current as $perm) {
						if (is_numeric($perm))
							array_push($permissions, $perm);
					}
				}
				$role->permissions()->attach($permissions);
			}

			return true;
		}

		throw new \Exception('There was a problem updating this role. Please try again.');
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws Exception
	 */
	public function destroy($id) {
		//Would be stupid to delete the administrator role
		if ($id == 1) //id is 1 because of the seeder
			throw new Exception("You can not delete the Administrator role.");

		$role = $this->findOrThrowException($id, true);

		//Don't delete the role is there are users associated
		if ($role->users()->count() > 0)
			throw new Exception("You can not delete a role with associated users.");

		//Detach all associated roles
		$role->permissions()->sync([]);

		if ($role->delete())
			return true;

		throw new Exception("There was a problem deleting this role. Please try again.");
	}

	/**
	 * @return mixed
	 */
	public function getDefaultUserRole() {
		return Role::where('name', 'Employee')->first();
	}
}