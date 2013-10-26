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
namespace CustomerTest\Service;

use Customer\Entity\CustomerEntity;
use Customer\Hydrator\CustomerHydrator;
use Customer\InputFilter\CustomerInputFilter;
use Customer\Service\CustomerService;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

/**
 * CustomerServiceTest
 *
 * Tests the customer service class of the Customer Module
 *
 * @package    CustomerTest
 */
class CustomerServiceTest extends PHPUnit_Framework_TestCase
{
    public function testServiceFileExistsAndIsInstantiable()
    {
        $className = 'Customer\Service\CustomerService';

        $this->assertTrue(class_exists($className));

        $customerService = new $className();

        $this->assertInstanceOf($className, $customerService);
    }

    public function testTableGetterWhenTableNotSet()
    {
        try {
            $customerService = new CustomerService();
            $customerTable   = $customerService->getCustomerTable();
        } catch (InvalidArgumentException $expected) {
            $this->assertEquals('CustomerTable was not set', $expected->getMessage());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testTableGetterWhenTableWasSet()
    {
        $mockDbDriver      = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDbAdapter     = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDbDriver));
        $mockCustomerTable = $this->getMock('Customer\Table\CustomerTable', null, array($mockDbAdapter));

        $customerService = new CustomerService();
        $customerService->setCustomerTable($mockCustomerTable);

        $this->assertEquals($mockCustomerTable, $customerService->getCustomerTable());
    }

    public function testFilterGetterWhenFilterNotSet()
    {
        try {
            $customerService = new CustomerService();
            $customerFilter   = $customerService->getCustomerFilter();
        } catch (InvalidArgumentException $expected) {
            $this->assertEquals('CustomerFilter was not set', $expected->getMessage());
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testFilterGetterWhenFilterWasSet()
    {
        $customerFilter = new CustomerInputFilter();

        $customerService = new CustomerService();
        $customerService->setCustomerFilter($customerFilter);

        $this->assertEquals($customerFilter, $customerService->getCustomerFilter());
    }

    public function testFetchListResult()
    {
        $data = array(
            42 => array(
                'id'        => 42,
                'firstname' => 'Manfred',
                'lastname'  => 'Mustermann',
                'street'    => 'Am Testen 123',
                'postcode'  => '54321',
                'city'      => 'Musterhausen',
                'country'   => 'de',
            ),
            43 => array(
                'id'        => 43,
                'firstname' => 'Manuela',
                'lastname'  => 'Musterfrau',
                'street'    => 'Am Mustern 987',
                'postcode'  => '98765',
                'city'      => 'Testhausen',
                'country'   => 'de',
            )
        );

        $mockDbStatement = $this->getMock('Zend\Db\Adapter\Driver\StatementInterface');
        $mockDbStatement->expects($this->any())->method('execute')->will($this->returnValue($data));

        $mockDbDriver = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDbDriver->expects($this->any())->method('createStatement')->will($this->returnValue($mockDbStatement));

        $mockDbAdapter = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDbDriver));

        $mockCustomerTable = $this->getMock('Customer\Table\CustomerTable', null, array($mockDbAdapter));

        $customerService = new CustomerService();
        $customerService->setCustomerTable($mockCustomerTable);

        $customerList = $customerService->fetchList();

        $this->assertInternalType('array', $customerList);

        foreach ($customerList as $key => $customerEntity) {
            $this->assertTrue($customerEntity instanceof CustomerEntity);

            $this->assertSame($data[$key]['id'], $customerEntity->getId());
            $this->assertSame($data[$key]['firstname'], $customerEntity->getFirstname());
            $this->assertSame($data[$key]['lastname'], $customerEntity->getLastname());
            $this->assertSame($data[$key]['street'], $customerEntity->getStreet());
            $this->assertSame($data[$key]['postcode'], $customerEntity->getPostcode());
            $this->assertSame($data[$key]['city'], $customerEntity->getCity());
            $this->assertSame($data[$key]['country'], $customerEntity->getCountry());
        }
    }

    public function testFetchSingleById()
    {
        $data = array(
            array(
                'id'        => 42,
                'firstname' => 'Manfred',
                'lastname'  => 'Mustermann',
                'street'    => 'Am Testen 123',
                'postcode'  => '54321',
                'city'      => 'Musterhausen',
                'country'   => 'de',
            )
        );

        $mockDbStatement = $this->getMock('Zend\Db\Adapter\Driver\StatementInterface');
        $mockDbStatement->expects($this->any())->method('execute')->will($this->returnValue($data));

        $mockDbDriver = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDbDriver->expects($this->any())->method('createStatement')->will($this->returnValue($mockDbStatement));

        $mockDbAdapter = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDbDriver));

        $mockCustomerTable = $this->getMock('Customer\Table\CustomerTable', null, array($mockDbAdapter));
        $mockCustomerTable->expects($this->any())->method('fetchSingleById')->will($this->returnValue(new CustomerEntity()));

        $customerService = new CustomerService();
        $customerService->setCustomerTable($mockCustomerTable);

        $customerEntity = $customerService->fetchSingleById(42);

        $this->assertTrue($customerEntity instanceof CustomerEntity);

        $this->assertSame($data[0]['id'], $customerEntity->getId());
        $this->assertSame($data[0]['firstname'], $customerEntity->getFirstname());
        $this->assertSame($data[0]['lastname'], $customerEntity->getLastname());
        $this->assertSame($data[0]['street'], $customerEntity->getStreet());
        $this->assertSame($data[0]['postcode'], $customerEntity->getPostcode());
        $this->assertSame($data[0]['city'], $customerEntity->getCity());
        $this->assertSame($data[0]['country'], $customerEntity->getCountry());
    }

    public function testSaveValidData()
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

        $expectedCustomerEntity = new CustomerEntity();

        $customerHydrator = new CustomerHydrator();
        $customerHydrator->hydrate($data, $expectedCustomerEntity);

        $mockDbStatement = $this->getMock('Zend\Db\Adapter\Driver\StatementInterface');
        $mockDbStatement->expects($this->any())->method('execute')->will($this->returnValue($data));

        $mockDbDriver = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDbDriver->expects($this->any())->method('createStatement')->will($this->returnValue($mockDbStatement));

        $mockDbAdapter = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDbDriver));

        $mockCustomerTable = $this->getMock('Customer\Table\CustomerTable', array('insertCustomer', 'getLastInsertValue', 'fetchSingleById'), array($mockDbAdapter));
        $mockCustomerTable->expects($this->any())->method('insertCustomer')->will($this->returnValue(42));
        $mockCustomerTable->expects($this->any())->method('getLastInsertValue')->will($this->returnValue(42));
        $mockCustomerTable->expects($this->any())->method('fetchSingleById')->will($this->returnValue($expectedCustomerEntity));

        $customerFilter = new CustomerInputFilter();
        $customerFilter->init();

        $customerService = new CustomerService();
        $customerService->setCustomerFilter($customerFilter);
        $customerService->setCustomerTable($mockCustomerTable);

        $customerEntity = $customerService->save($data);

        $this->assertTrue($customerEntity instanceof CustomerEntity);

        $this->assertSame($data['id'], $customerEntity->getId());
        $this->assertSame($data['firstname'], $customerEntity->getFirstname());
        $this->assertSame($data['lastname'], $customerEntity->getLastname());
        $this->assertSame($data['street'], $customerEntity->getStreet());
        $this->assertSame($data['postcode'], $customerEntity->getPostcode());
        $this->assertSame($data['city'], $customerEntity->getCity());
        $this->assertSame($data['country'], $customerEntity->getCountry());
    }

    public function testSaveInvalidData()
    {
        $data = array(
            'id'        => 'a',
            'firstname' => 'Manfred 0815',
            'lastname'  => '#(9(au',
            'street'    => '',
            'postcode'  => '64654564564646464654654654',
            'city'      => 'M',
            'country'   => 'it',
        );

        $customerFilter = new CustomerInputFilter();
        $customerFilter->init();

        $customerService = new CustomerService();
        $customerService->setCustomerFilter($customerFilter);

        $customerEntity = $customerService->save($data);

        $this->assertFalse($customerEntity);

    }

    public function testDeleteCustomer()
    {
        $customerService = new CustomerService();

        $result = $customerService->delete(42);

        $this->assertInternalType('boolean', $result);
    }
}