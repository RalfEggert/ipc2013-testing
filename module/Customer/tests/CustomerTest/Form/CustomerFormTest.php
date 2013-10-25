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

use Customer\Form\CustomerForm;
use PHPUnit_Framework_TestCase;
use Zend\Form\FormInterface;

/**
 * CustomerFormTest
 *
 * Tests the form for the customer
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

    public function testIdElementExists()
    {
        $customerForm = new CustomerForm();
        $customerForm->init();

        $idElement = $customerForm->get('id');

        $this->assertEquals('hidden', $idElement->getAttribute('type'));
    }

    public function testFirstnameElementExists()
    {
        $customerForm = new CustomerForm();
        $customerForm->init();

        $firstnameElement = $customerForm->get('firstname');

        $this->assertEquals('text', $firstnameElement->getAttribute('type'));
        $this->assertEquals('span5', $firstnameElement->getAttribute('class'));
        $this->assertEquals('Vorname', $firstnameElement->getLabel());
    }

    public function testLastnameElementExists()
    {
        $customerForm = new CustomerForm();
        $customerForm->init();

        $lastnameElement = $customerForm->get('lastname');

        $this->assertEquals('text', $lastnameElement->getAttribute('type'));
        $this->assertEquals('span5', $lastnameElement->getAttribute('class'));
        $this->assertEquals('Nachname', $lastnameElement->getLabel());
    }

    public function testStreetElementExists()
    {
        $customerForm = new CustomerForm();
        $customerForm->init();

        $streetElement = $customerForm->get('street');

        $this->assertEquals('text', $streetElement->getAttribute('type'));
        $this->assertEquals('span5', $streetElement->getAttribute('class'));
        $this->assertEquals('Straße', $streetElement->getLabel());
    }

    public function testPostcodeElementExists()
    {
        $customerForm = new CustomerForm();
        $customerForm->init();

        $postcodeElement = $customerForm->get('postcode');

        $this->assertEquals('text', $postcodeElement->getAttribute('type'));
        $this->assertEquals('span5', $postcodeElement->getAttribute('class'));
        $this->assertEquals('PLZ', $postcodeElement->getLabel());
    }

    public function testCityElementExists()
    {
        $customerForm = new CustomerForm();
        $customerForm->init();

        $cityElement = $customerForm->get('city');

        $this->assertEquals('text', $cityElement->getAttribute('type'));
        $this->assertEquals('span5', $cityElement->getAttribute('class'));
        $this->assertEquals('Stadt', $cityElement->getLabel());
    }

    public function testCountryElementExists()
    {
        $valueOptions = array(
            'de' => 'Deutschland',
            'at' => 'Österreich',
            'ch' => 'Schweiz',
        );

        $customerForm = new CustomerForm();
        $customerForm->init();

        $countryElement = $customerForm->get('country');

        $this->assertEquals('select', $countryElement->getAttribute('type'));
        $this->assertEquals('span5', $countryElement->getAttribute('class'));
        $this->assertEquals('Land', $countryElement->getLabel());
        $this->assertEquals($valueOptions, $countryElement->getValueOptions);
    }
}