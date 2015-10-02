<?php

class UserFactory
{

	private $users = [];

	function __construct()
	{
		$this->users = $this->setUsers();
	}

	public function getUsers()
	{
		return $this->users;
	}


	private function setUsers()
	{
		$inc = 3;
		while($inc > 0)
		{
			array_push($this->users, [
				'id' => $inc,
				'permissions' => [
					'1' => 'view-access',
					'2' => 'edit-access',
					'3' => 'delete-access'
				]
			]);
			$inc--;
		}
		// array_walk($this->users, array($this,'filterPermission'));
		return $this->users;
	}


	// private function filterPermission(&$item, $key)
	// {
	// 	if($key==0)
	// 		array_pop($item['permissions']);
	// }

}