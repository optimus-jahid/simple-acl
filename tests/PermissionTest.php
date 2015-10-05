<?php

use SimpleAcl\Repositories\PermissionRepository;

class PermissionTest extends TestFixture
{
	public function testCanCreatePermission()
	{
		$repository = new PermissionRepository();
		// $this->assertInstanceOf('PermissionRepository', $repository);
		$this->assertObjectHasAttribute('dal1', $repository);
		// insert into db and make sure that it's inserted
	}

	public function testCanAttachPermission()
	{
		// attach into a user and make sure it's attached
	}

	public function testCanDetachPermission()
	{
		// detach from user and make sure it's detached
	}

	public function testCanDestroyPermission()
	{
		// destory permission and make sure that's destory
	}

	public function testCanNotDestroyPermission()
	{
		// make sure that test can not destroy permission 
	}

}