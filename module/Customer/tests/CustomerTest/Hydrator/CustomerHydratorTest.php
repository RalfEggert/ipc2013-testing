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

    public function testHydrateMethod()
    {
        $data = array(
            'id'        => 42,
            'firstname' => 'Manfred',
            'lastname'  => 'Mustermann',
            'street'    => 'Am Testen 123',
            'postcode'  => '54321',
            'city'      => 'Musterhausen',
            'country'   => 'de',
        );

        $customerEntity = new \Customer\Entity\CustomerEntity();

        $customerHydrator = new \Customer\Hydrator\CustomerHydrator();
        $customerHydrator->hydrate($data, $customerEntity);

        $this->assertSame($data['id'], $customerEntity->getId());
        $this->assertSame($data['firstname'], $customerEntity->getFirstname());
        $this->assertSame($data['lastname'], $customerEntity->getLastname());
        $this->assertSame($data['street'], $customerEntity->getStreet());
        $this->assertSame($data['postcode'], $customerEntity->getPostcode());
        $this->assertSame($data['city'], $customerEntity->getCity());
        $this->assertSame($data['country'], $customerEntity->getCountry());
    }

    public function testExtractMethod()
    {
        $data = array(
            'id'        => 42,
            'firstname' => 'Manfred',
            'lastname'  => 'Mustermann',
            'street'    => 'Am Testen 123',
            'postcode'  => '54321',
            'city'      => 'Musterhausen',
            'country'   => 'de',
        );

        $customerEntity = new \Customer\Entity\CustomerEntity();
        $customerEntity->setId($data['id']);
        $customerEntity->setFirstname($data['firstname']);
        $customerEntity->setLastname($data['lastname']);
        $customerEntity->setStreet($data['street']);
        $customerEntity->setPostcode($data['postcode']);
        $customerEntity->setCity($data['city']);
        $customerEntity->setCountry($data['country']);

        $customerHydrator = new \Customer\Hydrator\CustomerHydrator();

        $extractedData = $customerHydrator->extract($customerEntity);

        $this->assertSame($data, $extractedData);
    }
}