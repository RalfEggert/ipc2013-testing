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

use Customer\InputFilter\CustomerInputFilter;
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

    public function testInvalidData()
    {
        $rawData = array(
            'id'        => 'a',
            'firstname' => 'Manfred 0815',
            'lastname'  => '#(9(au',
            'street'    => array('Am Testen 123'),
            'postcode'  => '64654564564646464654654654',
            'city'      => 'M',
            'country'   => 'it',
        );

        $expectedMessages = array(
            'id'        => 'Bla',
            'firstname' => 'Blub',
            'lastname'  => 'Sabber',
            'street'    => 'Troddel',
            'postcode'  => 'Honk',
            'city'      => 'Siff',
            'country'   => 'Nase',
        );

        $customerInputFilter = new CustomerInputFilter();
        $customerInputFilter->setData($rawData);

        $this->assertEquals(false, $customerInputFilter->isValid());
        $this->assertEquals($expectedMessages, $customerInputFilter->getMessages());
    }

    public function testValidData()
    {
        $rawData = array(
            'id'        => 42,
            'firstname' => 'ManFRED',
            'lastname'  => 'Mustermann',
            'street'    => 'Am tESTEN 123',
            'postcode'  => '54321',
            'city'      => 'MusterHauSen',
            'country'   => 'DE',
        );

        $expectedValues = array(
            'id'        => 42,
            'firstname' => 'Manfred',
            'lastname'  => 'Mustermann',
            'street'    => 'Am Testen 123',
            'postcode'  => '54321',
            'city'      => 'Musterhausen',
            'country'   => 'de',
        );

        $customerInputFilter = new CustomerInputFilter();
        $customerInputFilter->setData($rawData);

        $this->assertEquals(true, $customerInputFilter->isValid());
        $this->assertEquals($expectedValues, $customerInputFilter->getValues());
    }
}