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
use PHPUnit_Extensions_Database_DataSet_QueryDataSet;
use PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection;
use PHPUnit_Extensions_Database_TestCase;
use Zend\Db\Adapter\Adapter;

/**
 * CustomerTableDatabaseTest
 *
 * Tests the CustomerTable class in connection with a database
 *
 * @package    CustomerTest
 */
class CustomerTableDatabaseTest extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var Adapter
     */
    private $adapter = null;

    /**
     * @var PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
     */
    private $connection = null;

    /**
     * Get Database Connection
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        if (!$this->connection) {
            $dbConfig = array(
                'driver' => 'pdo',
                'dsn'    => 'mysql:dbname=ipc2013.testing.test;host=localhost;charset=utf8',
                'user'   => 'ipc2013',
                'pass'   => 'ipc2013',
            );

            $this->adapter = new Adapter($dbConfig);
            $this->connection = $this->createDefaultDBConnection(
                $this->adapter->getDriver()->getConnection()->getResource(),
                'ipc2013.testing.test'
            );
        }

        return $this->connection;
    }

    /**
     * Get DataSet
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createXmlDataSet(__DIR__ . '/customer-test-data.xml');
    }

    public function testFetchListOrderedByCountry()
    {
        $customerTable = new CustomerTable($this->adapter);
        $customerList  = $customerTable->fetchList();

        $queryTable = $this->getConnection()->createQueryTable(
            'loadCustomersOrderedByLastname', 'SELECT * FROM customers ORDER BY lastname;'
        );

        $this->assertEquals($queryTable->getRowCount(), $customerList->count());

        $hydrator = new CustomerHydrator();

        foreach ($customerList as $key => $customerEntity) {
            $expectedRow = $queryTable->getRow($key);
            $customerRow = $hydrator->extract($customerEntity);

            $this->assertEquals($expectedRow, $customerRow);
        }
    }

    public function testFetchListByCountryOrderedByCountry()
    {
        $customerTable = new CustomerTable($this->adapter);
        $customerList  = $customerTable->fetchList('de');

        $queryTable = $this->getConnection()->createQueryTable(
            'loadCustomersOrderedByLastname', 'SELECT * FROM customers WHERE country = "de" ORDER BY lastname;'
        );

        $this->assertEquals($queryTable->getRowCount(), $customerList->count());

        $hydrator = new CustomerHydrator();

        foreach ($customerList as $key => $customerEntity) {
            $expectedRow = $queryTable->getRow($key);
            $customerRow = $hydrator->extract($customerEntity);

            $this->assertEquals($expectedRow, $customerRow);
        }
    }

    public function testInsertNewCustomer()
    {
        $customerEntity = new CustomerEntity();
        $customerEntity->setId(99);
        $customerEntity->setFirstname('Horst');
        $customerEntity->setLastname('Hrubesch');
        $customerEntity->setStreet('Am Köpfen 124');
        $customerEntity->setPostcode('21451');
        $customerEntity->setCity('Hamburg');
        $customerEntity->setCountry('de');

        $customerTable = new CustomerTable($this->adapter);
        $customerTable->insertCustomer($customerEntity);

        $queryTable = $this->getConnection()->createQueryTable(
            'loadCustomersOrderedByLastname', 'SELECT * FROM customers WHERE id = "99";'
        );

        $expectedRow = $queryTable->getRow(0);

        $hydrator = new CustomerHydrator();
        $customerRow = $hydrator->extract($customerEntity);

        $this->assertEquals($expectedRow, $customerRow);
    }

    public function testUpdateExistingCustomer()
    {
        $customerTable = new CustomerTable($this->adapter);

        $customerEntity = $customerTable->fetchSingleById(42);
        $customerEntity->setFirstname('Monika');
        $customerEntity->setLastname('Musterfrau');

        $customerTable->updateCustomer($customerEntity);

        $queryTable = $this->getConnection()->createQueryTable(
            'loadCustomersOrderedByLastname', 'SELECT * FROM customers WHERE id = "42";'
        );

        $expectedRow = $queryTable->getRow(0);

        $hydrator = new CustomerHydrator();
        $customerRow = $hydrator->extract($customerEntity);

        $this->assertEquals($expectedRow, $customerRow);
    }

    public function testDeleteExistingCustomer()
    {
        $customerTable = new CustomerTable($this->adapter);

        $customerEntity = $customerTable->fetchSingleById(42);

        $customerTable->deleteCustomer($customerEntity);

        $queryTable = $this->getConnection()->createQueryTable(
            'loadCustomersOrderedByLastname', 'SELECT * FROM customers WHERE id = "42";'
        );

        $this->assertEquals(0, $queryTable->getRowCount());
    }
}