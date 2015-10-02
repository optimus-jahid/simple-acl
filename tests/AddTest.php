<?php

use SimpleAcl\SimpleAcl;

class AddTest extends TestFixture
{
    public function UserHasFullAccess()
    {
    	//$this->assertNull($this->users);
    	//$this->assertInternalType('array', $this->users);
    	//$this->assertCount(3, $this->users);
    	$expected = [
    		'id' => '2',
    		'permissions' => [
    			'1' => 'view-access',
				'2' => 'edit-access',
				'3' => 'delete-access'
    		]
    	];
    	// $this->assertSame($expected, $this->users[1]);
    	$this->assertEquals($expected, $this->users[1]);
    }

    public function UserHasLimitedAccess()
    {
    	//$this->assertNull($this->users);
    	//$this->assertInternalType('array', $this->users);
    	//$this->assertCount(3, $this->users);
    	$expected = [
    		'id' => '3',
    		'permissions' => [
    			'1' => 'view-access',
				'2' => 'edit-access'
    		]
    	];
    	// $this->assertSame($expected, $this->users[1]);
    	$this->assertEquals($expected, $this->users[0]);
    }

    public function UserHasNoAccess()
    {
    	//$this->assertNull($this->users);
    	//$this->assertInternalType('array', $this->users);
    	//$this->assertCount(3, $this->users);
    	$expected = [
    		'id' => '2',
    		'permissions' => [
    			'1' => 'view-access',
				'2' => 'edit-access',
				'3' => 'delete-access'
    		]
    	];
    	// $this->assertSame($expected, $this->users[1]);
    	$this->assertEquals($expected, $this->users[1]);
    }
}

