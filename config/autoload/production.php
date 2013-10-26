<?php
/**
 * Unit-Testing einer Zend Framework 2 Anwendung
 *
 * Zend Framework Session auf der International PHP Conference 2013 in München
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Ralf Eggert <r.eggert@travello.de>
 * @link       http://www.ralfeggert.de/
 */

/**
 * Global configuration
 *
 * @package    Application
 */
return array(
    'db' => array(
        'driver' => 'pdo',
        'dsn'    => 'mysql:dbname=ipc2013.testing.live;host=localhost;charset=utf8',
        'user'   => 'secret',
        'pass'   => 'secret',
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);