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

use Customer\Service\CustomerService;
use InvalidArgumentException;
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
        $className = 'Customer\Service\CustomerService';

        $this->assertTrue(class_exists($className));

        $customerService = new $className();

        $this->assertInstanceOf($className, $customerService);
    }

    public function testTableGetterWhenTableNotSet()
    {
        try {
            $customerService = new CustomerService();
            $customerTable   = $customerService->getCustomerTable();
        } catch (InvalidArgumentException $expected) {
            $this->assertEquals('CustomerTable was not set', $expected->getMessage());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testTableGetterWhenTableWasSet()
    {
        $mockDbDriver      = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDbAdapter     = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDbDriver));
        $mockCustomerTable = $this->getMock('Customer\Table\CustomerTable', null, array($mockDbAdapter));

        $customerService = new CustomerService();
        $customerService->setCustomerTable($mockCustomerTable);

        $this->assertEquals($mockCustomerTable, $customerService->getCustomerTable());
    }
}