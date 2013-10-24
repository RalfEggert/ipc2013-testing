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
namespace CustomerTest\InputFilter;

use PHPUnit_Framework_TestCase;
use Zend\InputFilter\InputFilterInterface;

/**
 * CustomerInputFilterTest
 *
 * Tests the input filter for the customer
 *
 * @package    CustomerTest
 */
class CustomerInputFilterTest extends PHPUnit_Framework_TestCase
{
    public function testInputFilterFileExistsAndIsInstantiable()
    {
        $className = 'Customer\InputFilter\CustomerInputFilter';

        $this->assertTrue(class_exists($className));

        $customerInputFilter = new $className();

        $this->assertInstanceOf($className, $customerInputFilter);
        $this->assertTrue($customerInputFilter instanceof InputFilterInterface);
    }
}