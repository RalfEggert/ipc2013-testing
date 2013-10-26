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
use Customer\Entity\CustomerEntity;
use Customer\Hydrator\CustomerHydrator;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

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

        $customerController = new IndexController();
        $customerController->setCustomerService($mockCustomerService);

        $this->assertEquals($mockCustomerService, $customerController->getCustomerService());
    }

    public function testFormGetterWhenFormNotSet()
    {
        try {
            $customerController = new IndexController();
            $customerForm    = $customerController->getCustomerForm();
        } catch (InvalidArgumentException $expected) {
            $this->assertEquals('CustomerForm was not set', $expected->getMessage());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testFormGetterWhenFormWasSet()
    {
        $mockCustomerForm = $this->getMock('Customer\Form\CustomerForm');

        $customerController = new IndexController();
        $customerController->setCustomerForm($mockCustomerForm);

        $this->assertEquals($mockCustomerForm, $customerController->getCustomerForm());
    }

    /**
     * Test index action view model
     */
    public function testIndexAction()
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

        $customerController = new IndexController();
        $customerController->setCustomerService($mockCustomerService);

        $viewModel = $customerController->indexAction();

        $customerList = $viewModel->getVariable('customerList');

        foreach ($expectedListData as $key => $customerEntity) {
            /** @var $customerEntity CustomerEntity */
            $this->assertEquals($customerEntity->getId(), $customerList[$key]->getId());
            $this->assertEquals($customerEntity->getFirstname(), $customerList[$key]->getFirstname());
            $this->assertEquals($customerEntity->getLastname(), $customerList[$key]->getLastname());
            $this->assertEquals($customerEntity->getStreet(), $customerList[$key]->getStreet());
            $this->assertEquals($customerEntity->getPostcode(), $customerList[$key]->getPostcode());
            $this->assertEquals($customerEntity->getCity(), $customerList[$key]->getCity());
            $this->assertEquals($customerEntity->getCountry(), $customerList[$key]->getCountry());
        }
    }

    /**
     * Test show action view model
     */
    public function testShowAction()
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

        $routeMatch = new RouteMatch(array('controller' => 'customer', 'action' => 'show', 'id' => 42));

        $mvcEvent = new MvcEvent();
        $mvcEvent->setRouteMatch($routeMatch);

        $customerController = new IndexController();
        $customerController->setCustomerService($mockCustomerService);
        $customerController->setEvent($mvcEvent);

        $viewModel = $customerController->showAction();

        $customerEntity = $viewModel->getVariable('customerEntity');

        foreach ($expectedListData as $key => $customerEntity) {
            /** @var $customerEntity CustomerEntity */
            $this->assertEquals($expectedEntity->getId(), $customerEntity->getId());
            $this->assertEquals($expectedEntity->getFirstname(), $customerEntity->getFirstname());
            $this->assertEquals($expectedEntity->getLastname(), $customerEntity->getLastname());
            $this->assertEquals($expectedEntity->getStreet(), $customerEntity->getStreet());
            $this->assertEquals($expectedEntity->getPostcode(), $customerEntity->getPostcode());
            $this->assertEquals($expectedEntity->getCity(), $customerEntity->getCity());
            $this->assertEquals($expectedEntity->getCountry(), $customerEntity->getCountry());
        }
    }
}