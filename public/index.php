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
 * Application setup
 * 
 * @package    Application
 */

// define request microtime
define('REQUEST_MICROTIME', microtime(true));

// define application environment
define('APPLICATION_ENV',  (getenv('APPLICATION_ENV') 
                          ? getenv('APPLICATION_ENV') 
                          : 'production'));

// define application path
define('APPLICATION_ROOT', realpath(__DIR__ . '/..'));

// setup autoloading
require_once '../vendor/autoload.php';

// change dir
chdir(dirname(__DIR__));

// get configuration file
switch (APPLICATION_ENV) {
	case 'production':
	    $configFile = APPLICATION_ROOT . '/config/production.config.php';
	    break;
	case 'development':
	default:
	    $configFile = APPLICATION_ROOT . '/config/development.config.php';
	    break;
}

// Run the application!
Zend\Mvc\Application::init(include $configFile)->run();
