<?php
/**
 * Unit-Testing einer Zend Framework 2 Anwendung
 *
 * Zend Framework Session auf der International PHP Conference 2013 in München
 *
 * @package    CustomerTest
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Ralf Eggert <r.eggert@travello.de>
 * @link       http://www.ralfeggert.de/
 */

/**
 * namespace definition and usage
 */
namespace CustomerTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * ModuleTest
 *
 * Tests the Module class of the Customer Module
 *
 * @package    CustomerTest
 */
class CustomerControllerTest extends AbstractHttpControllerTestCase
{
    /**
     * Setup test case
     */
    public function setUp()
    {
        $this->setApplicationConfig(include APPLICATION_ROOT . '/config/tests.config.php');

        parent::setUp();
    }

    /**
     * Test if index action can be accessed
     */
    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/customer');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Customer');
        $this->assertControllerName('customer');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('customer');
    }
}