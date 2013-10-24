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
namespace CustomerTest\Table;

use PHPUnit_Framework_TestCase;
use Zend\Db\TableGateway\TableGateway;

/**
 * CustomerTableApiTest
 *
 * Tests the API of the CustomerTable class
 *
 * @package    CustomerTest
 */
class CustomerTableApiTest extends PHPUnit_Framework_TestCase
{
    public function testTableFileExistsAndIsInstantiable()
    {
        $mockDbDriver  = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDbAdapter = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDbDriver));

        $className = 'Customer\Table\CustomerTable';

        $this->assertTrue(class_exists($className));

        $customerTable = new $className($mockDbAdapter);

        $this->assertInstanceOf($className, $customerTable);
        $this->assertTrue($customerTable instanceof TableGateway);
    }
}