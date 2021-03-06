<?php

namespace SimpleAcl\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use SimpleAcl\Migrations\Table;



class ModelSingleton{

	protected static $instance;

	public static function getInstance($config = [])
	{
		if (null === static::$instance) {
			static::$instance = new static($config);
		}

		return static::$instance;
	}

	protected function __construct($config = [])
	{
		//require_once realpath(__DIR__).'\..\Config.php';
		$capsule = new Capsule;

		$capsule->addConnection($config);

		// Set the event dispatcher used by Eloquent models... (optional)
		
		$capsule->setEventDispatcher(new Dispatcher(new Container));

		// Make this Capsule instance available globally via static methods... (optional)
		$capsule->setAsGlobal();

		// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
		$capsule->bootEloquent();

		// create tables
		$tables = new Table;
	}

	private function __clone()
	{
	}

	private function __wakeup()
	{
	}
}