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

    public function test_has_an_user_has_certain_permission()
    {
        $acl = new SimpleAcl;
        $this->assertTrue($acl->hasPermission('delete-user',1));   
    }

    public function test_has_an_user_doesnt_have_permission()
    {
        $acl = new SimpleAcl;
        $this->assertFalse($acl->hasPermission('delete-employee',1));   
    }

}

