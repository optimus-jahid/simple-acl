<?php
use SimpleAcl\SimpleAcl;
use Illuminate\Database\Capsule\Manager as Capsule;
/*
 * This file is part of the Simple ACL package.
 *
 * (c) Jahidul Islam <boithacoders@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/../vendor/autoload.php';


class TestFixture extends \PHPUnit_Framework_TestCase
{
    protected static $factory;
    protected $users;

    protected function setUp()
    {
        // //setup factory
        // if (null === static::$factory) {
        //     static::$factory = new UserFactory;
        // }
        // // $factory = new UserFactory;
        // // $this->users = $factory->getUsers();
        // $this->users = static::$factory->getUsers();

        // initiate db connection
        $db_config = [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'simple_acl',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
        ];

        setDbConfig($db_config);
        

    }



    protected function tearDown()
    {
        // date_default_timezone_set($this->users);
        // clean user
        // clean permissions
        // clean user_permission
    }
}