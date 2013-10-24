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

use Customer\Entity\CustomerEntity;
use Customer\Hydrator\CustomerHydrator;
use Customer\Table\CustomerTable;
use PHPUnit_Framework_Assert;
use PHPUnit_Framework_TestCase;
use Zend\Db\ResultSet\HydratingResultSet;
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
        $mockDbDriver  = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDbAdapter = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDbDriver));

        $className = 'Customer\Table\CustomerTable';

        $this->assertTrue(class_exists($className));

        $customerTable = new $className($mockDbAdapter);

        $this->assertInstanceOf($className, $customerTable);
        $this->assertTrue($customerTable instanceof TableGateway);
    }

    public function testTableName()
    {
        $mockDbDriver  = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDbAdapter = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDbDriver));

        $customerTable = new CustomerTable($mockDbAdapter);

        $this->assertEquals('customers', $customerTable->getTable());
    }

    public function testResultSetPrototype()
    {
        $mockDbDriver  = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDbAdapter = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDbDriver));

        $customerTable = new CustomerTable($mockDbAdapter);

        $resultSetPrototype = $customerTable->getResultSetPrototype();

        $this->assertTrue($resultSetPrototype instanceof HydratingResultSet);
        $this->assertTrue($resultSetPrototype->getHydrator() instanceof CustomerHydrator);

        $objectPrototype = PHPUnit_Framework_Assert::readAttribute($resultSetPrototype, 'objectPrototype');

        $this->assertTrue($objectPrototype instanceof CustomerEntity);
    }

    public function testFetchListResult()
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
            ),
            array(
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

        $customerTable = new CustomerTable($mockDbAdapter);
        $customerList  = $customerTable->fetchList();

        $this->assertEquals($data, $customerList->toArray());
    }

    public function testFetchSingleByIdResult()
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

        $customerTable  = new CustomerTable($mockDbAdapter);
        $customerEntity = $customerTable->fetchSingleById(42);

        $this->assertInstanceOf('Customer\Entity\CustomerEntity', $customerEntity);

        $this->assertSame($data[0]['id'], $customerEntity->getId());
        $this->assertSame($data[0]['firstname'], $customerEntity->getFirstname());
        $this->assertSame($data[0]['lastname'], $customerEntity->getLastname());
        $this->assertSame($data[0]['street'], $customerEntity->getStreet());
        $this->assertSame($data[0]['postcode'], $customerEntity->getPostcode());
        $this->assertSame($data[0]['city'], $customerEntity->getCity());
        $this->assertSame($data[0]['country'], $customerEntity->getCountry());
    }
}