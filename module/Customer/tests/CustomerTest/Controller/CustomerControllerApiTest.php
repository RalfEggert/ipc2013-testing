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

use Customer\Controller\IndexController;
use PHPUnit_Framework_TestCase;

/**
 * CustomerControllerViewModelTest
 *
 * Tests the API for the customer controller
 *
 * @package    CustomerTest
 */
class CustomerControllerApiTest extends PHPUnit_Framework_TestCase
{
    public function testServiceGetterWhenServiceNotSet()
    {
        try {
            $customerController = new IndexController();
            $customerService    = $customerController->getCustomerService();
        } catch (InvalidArgumentException $expected) {
            $this->assertEquals('CustomerService was not set', $expected->getMessage());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testServiceGetterWhenServiceWasSet()
    {
        $mockCustomerService = $this->getMock('Customer\Service\CustomerService');

        $controller = new IndexController();
        $controller->setCustomerService($mockCustomerService);

        $this->assertEquals($mockCustomerService, $controller->getCustomerService());
    }

    /**
     * Test index action view model
     */
    public function testIndexAction()
    {
        return;

        $data = array(
            array(
                'id'        => 42,
                'firstname' => 'Manfred',
                'lastname'  => 'Mustermann',
                'street'    => 'Am Testen 123',
                'postcode'  => '54321',
                'city'      => 'Musterhausen',
                'country'   => 'de',
            ),
            array(
                'id'        => 43,
                'firstname' => 'Manuela',
                'lastname'  => 'Musterfrau',
                'street'    => 'Am Mustern 987',
                'postcode'  => '98765',
                'city'      => 'Testhausen',
                'country'   => 'de',
            )
        );

        $customerHydrator = new CustomerHydrator();

        $expectedListData = array();

        foreach ($data as $row) {

            $expectedListData[$row['id']] = new CustomerEntity();

            $customerHydrator->hydrate($row, $expectedListData[$row['id']]);
        }

        $mockCustomerService = $this->getMockBuilder('Customer\Service\CustomerService')->getMock();
        $mockCustomerService->expects($this->any())->method('fetchList')->will($this->returnValue($expectedListData));

        $controller->setCustomerService();

        $result = $controller->indexAction();

        \Zend\Debug\Debug::dump($result);




        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Customer\Service\CustomerService', $mockCustomerService);

        $result = $this->dispatch('/customer');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Customer');
        $this->assertControllerName('customer');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('customer');

        foreach ($expectedListData as $customerEntity) {
            /** @var $customerEntity CustomerEntity */
            $this->assertContains($customerEntity->getFirstname(), $this->getResponse());
            $this->assertContains($customerEntity->getLastname(), $this->getResponse());
            $this->assertContains($customerEntity->getStreet(), $this->getResponse());
            $this->assertContains($customerEntity->getPostcode(), $this->getResponse());
            $this->assertContains($customerEntity->getCity(), $this->getResponse());
            $this->assertContains($customerEntity->getCountry(), $this->getResponse());
        }
    }
}