<?php
/**
 * Unit-Testing einer Zend Framework 2 Anwendung
 *
 * Zend Framework Session auf der International PHP Conference 2013 in München
 *
 * @package    Customer
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Ralf Eggert <r.eggert@travello.de>
 * @link       http://www.ralfeggert.de/
 */

/**
 * namespace definition and usage
 */
namespace CustomerTest;

use RuntimeException;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * PHP Configuration
 */
error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Bootstrap
 *
 * Handles the bootstrapping for the unit tests of the Customer module
 *
 * @package    Customer
 */
class Bootstrap
{
    /**
     * @var ServiceManager
     */
    protected static $serviceManager;

    /**
     * Get the service manager
     */
    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    /**
     * Change to root path
     */
    public static function chroot()
    {
        $rootPath = dirname(APPLICATION_ROOT . 'module');
        chdir($rootPath);
    }

    /**
     * Initialize the Bootstrapping
     */
    public static function init()
    {
        define('APPLICATION_ROOT', realpath(__DIR__ . '/../../..'));

        static::initAutoloader();

        $config = include APPLICATION_ROOT . '/config/tests.config.php';

        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        static::$serviceManager = $serviceManager;
    }

    /**
     * Initialize autoloader
     */
    protected static function initAutoloader()
    {
        $vendorPath = APPLICATION_ROOT . '/vendor';

        if (is_dir($vendorPath . '/zendframework/zendframework/library')) {
            $zf2Path = $vendorPath . '/zendframework/zendframework/library';
        }

        if (!$zf2Path) {
            throw new RuntimeException(
                'Unable to load ZF2. Run `php composer.phar install` or'
                . ' define a ZF2_PATH environment variable.'
            );
        }

        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }

        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';

        AutoloaderFactory::factory(
            array(
                'Zend\Loader\StandardAutoloader' => array(
                    'autoregister_zf' => true,
                    'namespaces'      => array(
                        __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                    ),
                ),
            )
        );
    }
}

/**
 * Start bootstrapping
 */
Bootstrap::init();
Bootstrap::chroot();