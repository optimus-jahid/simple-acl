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

        throw new Exception('That user does not exist.');
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
}