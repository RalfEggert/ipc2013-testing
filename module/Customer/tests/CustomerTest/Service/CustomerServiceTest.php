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
namespace CustomerTest\Service;

use PHPUnit_Framework_TestCase;

/**
 * CustomerServiceTest
 *
 * Tests the customer service class of the Customer Module
 *
 * @package    CustomerTest
 */
class CustomerServiceTest extends PHPUnit_Framework_TestCase
{
    public function testServiceFileExistsAndIsInstantiable()
    {
        $mockCustomerTable  = $this->getMock('Customer\Table\CustomerTable');
        $mockCustomerFilter = $this->getMock('Customer\InputFilter\CustomerInputFilter');

        $className = 'Customer\Service\CustomerService';

        $this->assertTrue(class_exists($className));

        $customerService = new $className($mockCustomerTable, $mockCustomerFilter);

        $this->assertInstanceOf($className, $customerService);
    }
}