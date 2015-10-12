<?php

namespace SimpleAcl\Repositories;

use SimpleAcl\Models\User;

class UserRepository
{

    /**
     * @param $id
     * @param bool $withRoles
     * @return mixed
     * @throws Exception
     */
    public function findOrThrowException($id, $withRoles = false) {
        if ($withRoles)
            $user = User::with('roles')->withTrashed()->find($id);
        else
            $user = User::withTrashed()->find($id);

        if (! is_null($user)) return $user;

        throw new \Exception('That user does not exist.');
    }

    /**
     * Check to make sure at lease one role is being applied or deactivate user
     * @param $user
     * @param $roles
     * @throws UserNeedsRolesException
     */
    private function validateRoleAmount($user, $roles) {
        //Validate that there's at least one role chosen, placing this here so
        //at lease the user can be updated first, if this fails the roles will be
        //kept the same as before the user was updated
        if (count($roles) == 0) {
            //Deactivate user
            $user->status = 0;
            $user->save();

            $exception = new UserNeedsRolesException();
            $exception->setValidationErrors('You must choose at lease one role. User has been created but deactivated.');

            //Grab the user id in the controller
            $exception->setUserID($user->id);
            throw $exception;
        }
    }

    /**
     * @param $roles
     * @param $user
     */
    private function flushRoles($roles, $user)
    {
        //Flush roles out, then add array of new ones
        $user->detachRoles($user->roles);
        $user->attachRoles($roles['assignees_roles']);
    }

    /**
     * @param $permissions
     * @param $user
     */
    private function flushPermissions($permissions, $user)
    {
        //Flush permissions out, then add array of new ones if any
        $user->detachPermissions($user->permissions);
        if (count($permissions['permission_user']) > 0)
            $user->attachPermissions($permissions['permission_user']);
    }

    /**
     * @param $roles
     * @throws Exception
     */
    private function checkUserRolesCount($roles)
    {
        //User Updated, Update Roles
        //Validate that there's at least one role chosen
        if (count($roles['assignees_roles']) == 0)
            throw new Exception('You must choose at least one role.');
    }

    public function attachRoles($roles, $user_id){
        $user = $this->findOrThrowException($user_id);
        $user->roles()->sync($roles);
        return true;
    }

    private function checkRole($nameOrId, $user)
    {
        foreach ($user->roles as $role) {
            //First check to see if it's an ID
            if (is_numeric($nameOrId))
                if ($role->id == $nameOrId)
                    return true;

            //Otherwise check by name
            if ($role->name == $nameOrId)
                return true;

            return false;
        }
    }

    public function hasRole($nameOrId, $user_id)
    {
        $user = $this->findOrThrowException($user_id);
        return $this->checkRole($nameOrId, $user);
    }

    public function hasRoles($roles, $user_id, $needsAll=false)
    {
        //User has to possess all of the roles specified
        if ($needsAll) {
            $hasRoles = 0;
            $numRoles = count($roles);

            foreach ($roles as $role) {
                if ($this->hasRole($role, $user_id))
                    $hasRoles++;
            }

            return $numRoles == $hasRoles;
        }

        //User has to possess one of the roles specified
        $hasRoles = 0;
        foreach ($roles as $role) {
            if ($this->hasRole($role, $user_id))
                $hasRoles++;
        }

        return $hasRoles > 0;
    }

    public function checkPermission($nameOrId, $user)
    {

        foreach ($user->roles as $role) {
            //See if role has all permissions
            if ($role->all)
                return true;

            // Validate against the Permission table
            foreach ($role->permissions as $perm) {

                //First check to see if it's an ID
                if (is_numeric($nameOrId))
                    if ($perm->id == $nameOrId)
                        return true;

                //Otherwise check by name
                if ($perm->name == $nameOrId)
                    return true;
            }
        }

        return false;
    }

    public function hasPermission($ability, $user_id)
    {
        $user = $this->findOrThrowException($user_id, true);
        return $this->checkPermission($ability, $user);
    }

    public function hasPermissions($permissions, $user_id, $needsAll=false)
    {
        //User has to possess all of the permissions specified
        if ($needsAll)
        {
            $hasPermissions = 0;
            $numPermissions = count($permissions);

            foreach ($permissions as $perm)
            {
                if ($this->hasPermission($perm, $user_id))
                    $hasPermissions++;
            }

            return $numPermissions == $hasPermissions;
        }

        //User has to possess one of the permissions specified
        $hasPermissions = 0;
        foreach ($permissions as $perm) {
            if ($this->hasPermission($perm, $user_id))
                $hasPermissions++;
        }

        return $hasPermissions > 0;
    }
}