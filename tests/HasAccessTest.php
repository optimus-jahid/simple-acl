<?php

use SimpleAcl\SimpleAcl;
use Illuminate\Database\Capsule\Manager as Capsule;

class HasAccessTest extends TestFixture
{
    public function test_an_user_has_certain_role()
    {
        $acl = new SimpleAcl;
        $this->assertTrue($acl->hasRole(3,1));
    }

    public function test_an_user_doesnt_have_certain_role()
    {
        $acl = new SimpleAcl;
        $this->assertFalse($acl->hasRole(4,1));
    }

    public function test_an_user_has_certain_permission()
    {
        $acl = new SimpleAcl;
        $this->assertTrue($acl->hasPermission('delete-user',1));   
    }

    public function test_an_user_doesnt_have_permission()
    {
        $acl = new SimpleAcl;
        $this->assertFalse($acl->hasPermission('delete-employee',1));   
    }

    public function test_an_user_has_at_least_one_role()
    {
        $acl = new SimpleAcl;
        $this->assertTrue($acl->hasRoles([2,3],1));
    }

    public function test_an_user_doesnt_have_all_necessary_roles()
    {
        $acl = new SimpleAcl;
        $this->assertFalse($acl->hasRoles([2,3],1, true));
    }

    public function test_an_user_has_at_least_one_permission()
    {
        $acl = new SimpleAcl;
        $this->assertTrue($acl->hasPermissions(['delete-employee', 'delete-user'],1));
    }

    public function test_an_user_doesnt_have_all_necessary_permission()
    {
        $acl = new SimpleAcl;
        $this->assertFalse($acl->hasPermissions(['delete-employee', 'delete-user'],1,true));
        $this->assertFalse(access()->hasPermissions(['delete-employee', 'delete-user'],1,true));

    }
}

