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

use Customer\Entity\CustomerEntity;
use Customer\Hydrator\CustomerHydrator;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * CustomerControllerMvcTest
 *
 * Tests the mvc part for the customer controller
 *
 * @package    CustomerTest
 */
class CustomerControllerMvcTest extends AbstractHttpControllerTestCase
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

    /**
     * Test if index action view result is as expected
     */
    public function testIndexActionViewResultAsExpected()
    {
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

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Customer\Service\Customer', $mockCustomerService);

        $this->dispatch('/customer');

        foreach ($expectedListData as $customerEntity) {
            /** @var $customerEntity CustomerEntity */
            $this->assertContains((string) $customerEntity->getId(), $this->getResponse()->getContent());
            $this->assertContains($customerEntity->getFirstname(), $this->getResponse()->getContent());
            $this->assertContains($customerEntity->getLastname(), $this->getResponse()->getContent());
            $this->assertContains($customerEntity->getStreet(), $this->getResponse()->getContent());
            $this->assertContains($customerEntity->getPostcode(), $this->getResponse()->getContent());
            $this->assertContains($customerEntity->getCity(), $this->getResponse()->getContent());
            $this->assertContains($customerEntity->getCountry(), $this->getResponse()->getContent());
        }
    }

    /**
     * Test if show action can be accessed
     */
    public function testShowActionCanBeAccessed()
    {
        $mockCustomerService = $this->getMockBuilder('Customer\Service\CustomerService')->getMock();
        $mockCustomerService->expects($this->any())->method('fetchSingleById')->will($this->returnValue(new CustomerEntity()));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Customer\Service\Customer', $mockCustomerService);

        $this->dispatch('/customer/show/1');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Customer');
        $this->assertControllerName('customer');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('customer/action');
    }

    /**
     * Test if show action view result is as expected
     */
    public function testShowActionViewResultAsExpected()
    {
        $data = array(
            'id'        => 42,
            'firstname' => 'Manfred',
            'lastname'  => 'Mustermann',
            'street'    => 'Am Testen 123',
            'postcode'  => '54321',
            'city'      => 'Musterhausen',
            'country'   => 'de',
        );

        $expectedEntity = new CustomerEntity();

        $customerHydrator = new CustomerHydrator();
        $customerHydrator->hydrate($data, $expectedEntity);

        $mockCustomerService = $this->getMockBuilder('Customer\Service\CustomerService')->getMock();
        $mockCustomerService->expects($this->any())->method('fetchSingleById')->will($this->returnValue($expectedEntity));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Customer\Service\Customer', $mockCustomerService);

        $this->dispatch('/customer/show/42');

        $this->assertContains((string) $expectedEntity->getId(), $this->getResponse()->getContent());
        $this->assertContains($expectedEntity->getFirstname(), $this->getResponse()->getContent());
        $this->assertContains($expectedEntity->getLastname(), $this->getResponse()->getContent());
        $this->assertContains($expectedEntity->getStreet(), $this->getResponse()->getContent());
        $this->assertContains($expectedEntity->getPostcode(), $this->getResponse()->getContent());
        $this->assertContains($expectedEntity->getCity(), $this->getResponse()->getContent());
        $this->assertContains($expectedEntity->getCountry(), $this->getResponse()->getContent());
    }

    /**
     * Test if create action can be accessed
     */
    public function testCreateActionCanBeAccessed()
    {
        $mockCustomerService = $this->getMockBuilder('Customer\Service\CustomerService')->getMock();

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Customer\Service\Customer', $mockCustomerService);

        $this->dispatch('/customer/create');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Customer');
        $this->assertControllerName('customer');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('customer/action');
    }

}