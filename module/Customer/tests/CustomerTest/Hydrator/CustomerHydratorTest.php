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
namespace CustomerTest\Hydrator;

use PHPUnit_Framework_TestCase;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * ModuleTest
 *
 * Tests the Module class of the Customer Module
 *
 * @package    CustomerTest
 */
class CustomerHydratorTest extends PHPUnit_Framework_TestCase
{
    public function testHydratorFileExistsAndIsInstantiable()
    {
        $className = 'Customer\Hydrator\CustomerHydrator';

        $this->assertTrue(class_exists($className));

        $customerHydrator = new $className();

        $this->assertInstanceOf($className, $customerHydrator);
        $this->assertTrue($customerHydrator instanceof HydratorInterface);
    }
}