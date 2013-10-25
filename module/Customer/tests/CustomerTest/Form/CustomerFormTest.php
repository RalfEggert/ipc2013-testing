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
namespace CustomerTest\Form;

use PHPUnit_Framework_TestCase;
use Zend\Form\FormInterface;

/**
 * CustomerFormTest
 *
 * Tests the input filter for the customer
 *
 * @package    CustomerTest
 */
class CustomerFormTest extends PHPUnit_Framework_TestCase
{
    public function testFormFileExistsAndIsInstantiable()
    {
        $className = 'Customer\Form\CustomerForm';

        $this->assertTrue(class_exists($className));

        $customerForm = new $className();

        $this->assertInstanceOf($className, $customerForm);
        $this->assertTrue($customerForm instanceof FormInterface);
    }
}