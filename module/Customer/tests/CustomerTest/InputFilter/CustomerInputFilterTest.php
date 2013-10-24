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
            'street'    => '',
            'postcode'  => '64654564564646464654654654',
            'city'      => 'M',
            'country'   => 'it',
        );

        $expectedMessages = array(
            'id'        => array(
                'notInt' => 'The input does not appear to be an integer',
            ),
            'firstname' => array(
                'notAlpha' => 'The input contains non alphabetic characters',
            ),
            'lastname'  => array(
                'notAlpha' => 'The input contains non alphabetic characters',
            ),
            'street'    => array(
                'isEmpty' => 'Value is required and can\'t be empty',
            ),
            'postcode'  => array(
                'postcodeNoMatch' => 'The input does not appear to be a postal code',
            ),
            'city'      => array(
                'stringLengthTooShort' => 'The input is less than 3 characters long',
            ),
            'country'      => array(
                'notInArray' => 'The input was not found in the haystack',
            ),
        );

        $customerInputFilter = new CustomerInputFilter();
        $customerInputFilter->init();
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
            'country'   => 'de',
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
        $customerInputFilter->init();
        $customerInputFilter->setData($rawData);

        $this->assertEquals(true, $customerInputFilter->isValid());
        $this->assertEquals($expectedValues, $customerInputFilter->getValues());
    }
}