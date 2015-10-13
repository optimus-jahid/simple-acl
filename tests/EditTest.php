<?php

use SimpleAcl\SimpleAcl;

class EditTest extends TestFixture
{
	public function test_can_update_permission()
	{
		$params = [
			'name' => 'delete-employee',
			'display_name' => 'delete employee'
		];

		$this->assertTrue(access()->updatePermission(4, $params));
	}

	public function test_can_update_role()
	{
		$params = [
			'name' => 'delete-employee',
			'display_name' => 'delete employee'
		];
		
		$this->assertTrue(access()->updatePermission($params, 4));
	}
}