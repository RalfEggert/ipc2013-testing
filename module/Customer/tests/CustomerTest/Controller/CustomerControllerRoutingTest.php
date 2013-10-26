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
 * CustomerControllerRoutingTest
 *
 * Tests the routing for the customer controller
 *
 * @package    CustomerTest
 */
class CustomerControllerRoutingTest extends AbstractHttpControllerTestCase
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
        $mockCustomerService = $this->getMockBuilder('Customer\Service\CustomerService')->getMock();
        $mockCustomerService->expects($this->any())->method('fetchList')->will($this->returnValue(array()));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Customer\Service\Customer', $mockCustomerService);

        $this->dispatch('/customer');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Customer');
        $this->assertControllerName('customer');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('customer');
    }
}