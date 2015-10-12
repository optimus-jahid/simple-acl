<?php

use SimpleAcl\SimpleAcl;
use Illuminate\Database\Capsule\Manager as Capsule;

class AddTest extends TestFixture
{
    
    // ----------------------- PASSED TEST -----------------//

    /*public function testHasInstance()
    {
        $instance = new SimpleAcl;
        $this->assertInstanceOf('SimpleAcl\SimpleAcl', $instance);

    }*/

    /*public function test_can_add_permission()
    {
        $params = [
            [
                'name' => 'view-user',
                'display_name' => 'view user'
            ],
            [
                'name' => 'edit-user',
                'display_name' => 'edit user'
            ],
            [
                'name' => 'delete-user',
                'display_name' => 'delete user'
            ]
        ];

        $acl = new SimpleAcl;
        foreach($params as $param)
            $this->assertTrue($acl->createPermission($param));
        }*/

        /*public function test_can_add_roles()
        {
            $roles = [
                [
                    'name' => 'super-admin',
                    'associated-permissions' => 'all'
                ],
                [
                    'name' => 'admin',
                    'associated-permissions' => null,
                    'permissions' => '1,2'
                ],
                [
                    'name' => 'employee',
                    'associated-permissions' => null,
                    'permissions' => 1
                ]
            ];

            $acl = new SimpleAcl;
            foreach($roles as $role)
                $this->assertTrue($acl->createRole($role));
        }*/

    /*public function test_roles_can_be_assigend_to_user()
    {
        $role_ids = [1,2,3];
        $user_id = 1;
        $acl = new SimpleAcl;
        $this->assertTrue($acl->attachUserRole($role_ids, $user_id));
    }*/

    public function testEmpty()
    {
        
    }
}

