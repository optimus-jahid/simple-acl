<?php

namespace SimpleAcl;

use SimpleAcl\Models\ModelSingleton;

class SimpleAcl
{
	public function __construct()
	{
		ModelSingleton::getInstance();
	}
}