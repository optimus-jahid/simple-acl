<?php

namespace SimpleAcl\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class Table
{

	// private $createUserTable = false;

	function __construct() 
	{
		// $this->createUserTable = $createUserTable;
		if (Capsule::schema()->hasTable('permissions')) {
		    return true;
		}
		$this->generateTables();
	}

	private function generateTables()
	{
		$this->userTable();
		$this->permissionTable();
		$this->roleTable();
		$this->permissionUserTable();
		$this->assignedRolesTable();
		$this->permissionRoleTable();
	}

	private function userTable()
	{
		Capsule::schema()->create('users', function($table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->timestamps();
		});

	}

	private function permissionTable()
	{
		Capsule::schema()->create('permissions', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('group_id')->nullable();
			$table->string('name')->unique();
			$table->string('display_name');
			$table->boolean('system')->default(false);
			$table->smallInteger('sort')->default(0);
			$table->timestamps();
		});

		Capsule::schema()->create('permission_dependencies', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('permission_id')->unsigned();
			$table->integer('dependency_id')->unsigned();
			$table->foreign('permission_id')
				->references('id')
				->on('permissions');
			$table->foreign('dependency_id')
				->references('id')
				->on('permissions');
			$table->timestamps();
		});
	}

	private function roleTable()
	{
		Capsule::schema()->create('roles', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('name')->unique();
			$table->boolean('all')->default(false);
			$table->smallInteger('sort')->default(0);
			$table->timestamps();
		});
	}

	private function permissionUserTable()
	{
		Capsule::schema()->create('permission_user', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('permission_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->foreign('permission_id')
				->references('id')
				->on('permissions');
			$table->foreign('user_id')
				->references('id')
				->on('users');
		});

	}

	private function assignedRolesTable()
	{
		Capsule::schema()->create('assigned_roles', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles');
		});
	}

	private function permissionRoleTable()
	{
		Capsule::schema()->create('permission_role', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('permission_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->foreign('permission_id')
				->references('id')
				->on('permissions');
			$table->foreign('role_id')
				->references('id')
				->on('roles');
		});
	}

}