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
 * ModuleTest
 *
 * Tests the Module class of the Customer Module
 *
 * @package    CustomerTest
 */
class CustomerTableTest extends PHPUnit_Framework_TestCase
{
    public function testTableFileExistsAndIsInstantiable()
    {
        $className = 'Customer\Table\CustomerTable';

        $this->assertTrue(class_exists($className));

        $customerTable = new $className();

        $this->assertInstanceOf($className, $customerTable);
        $this->assertTrue($customerTable instanceof TableGateway);
    }
}