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
use InvalidArgumentException;
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

        $controller = new IndexController();
        $controller->setCustomerForm($mockCustomerForm);

        $this->assertEquals($mockCustomerForm, $controller->getCustomerForm());
    }
}