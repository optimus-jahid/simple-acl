<?php

namespace SimpleAcl;

use SimpleAcl\Models\ModelSingleton;
use SimpleAcl\Traits\Authorizable;

class SimpleAcl
{

	use Authorizable;

	public static $connectionConfig = null;

	public function __construct()
	{
		ModelSingleton::getInstance(self::$connectionConfig); // --to create tables
	}

	public static function initialize($config)
	{
		self::$connectionConfig = $config; // --to create tables
	}
}