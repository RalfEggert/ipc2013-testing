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
namespace CustomerTest\Entity;

use PHPUnit_Framework_TestCase;

/**
 * ModuleTest
 *
 * Tests the Module class of the Customer Module
 *
 * @package    CustomerTest
 */
class CustomerEntityTest extends PHPUnit_Framework_TestCase
{
    public function testEntityFileExistsAndIsInstantiable()
    {
        $className = 'Customer\Entity\CustomerEntity';

        $this->assertTrue(class_exists($className));

        $customerEntity = new $className();

        $this->assertInstanceOf($className, $customerEntity);
    }

    public function testIdProperty()
    {
        $value = 42;

        $customerEntity = new \Customer\Entity\CustomerEntity();
        $customerEntity->setId($value);

        $this->assertEquals($value, $customerEntity->getId());
    }

}