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
use Customer\Table\CustomerTable;
use PHPUnit_Extensions_Database_DataSet_QueryDataSet;
use PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection;
use PHPUnit_Extensions_Database_TestCase;
use Zend\Db\Adapter\Adapter;

/**
 * CustomerServiceDatabaseTest
 *
 * Tests the CustomerService class in connection with a database
 *
 * @package    CustomerTest
 */
class CustomerServiceDatabaseTest extends PHPUnit_Extensions_Database_TestCase
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
        $customerFilter = new CustomerInputFilter();
        $customerTable  = new CustomerTable($this->adapter);

        $customerService = new CustomerService();
        $customerService->setCustomerFilter($customerFilter);
        $customerService->setCustomerTable($customerTable);

        $customerList = $customerService->fetchList();

        $queryTable = $this->getConnection()->createQueryTable(
            'loadCustomersOrderedByLastname', 'SELECT * FROM customers ORDER BY lastname;'
        );

        $this->assertEquals($queryTable->getRowCount(), count($customerList));

        $hydrator = new CustomerHydrator();

        foreach ($customerList as $key => $customerEntity) {
            $expectedRow = $queryTable->getRow($key);
            $customerRow = $hydrator->extract($customerEntity);

            $this->assertEquals($expectedRow, $customerRow);
        }
    }
}