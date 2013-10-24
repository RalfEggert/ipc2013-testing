<?php
/**
 * Unit-Testing einer Zend Framework 2 Anwendung
 *
 * Zend Framework Session auf der International PHP Conference 2013 in München
 *
 * @package    Customer
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Ralf Eggert <r.eggert@travello.de>
 * @link       http://www.ralfeggert.de/
 */

/**
 * namespace definition and usage
 */
namespace Customer\Table;

use Customer\Entity\CustomerEntity;
use Customer\Hydrator\CustomerHydrator;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;

/**
 * Customer table
 *
 * Table gateway class to represent customers database table
 *
 * @package    Customer
 */
class CustomerTable extends TableGateway
{
    /**
     * Constructor
     *
     * @param AdapterInterface $adapter
     *
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(AdapterInterface $adapter)
    {
        $resultSetPrototype = new HydratingResultSet(
            new CustomerHydrator(),
            new CustomerEntity()
        );

        parent::__construct('customers', $adapter, null, $resultSetPrototype);
    }

    /**
     * Fetch customer list
     *
     * @return HydratingResultSet
     */
    public function fetchList($country = null)
    {
        $select = $this->getSql()->select();
        $select->order('lastname');

        if (!is_null($country)) {
            $select->where->equalTo('country', $country);
        }

        return $this->selectWith($select);
    }

    /**
     * Fetch single customer by id
     *
     * @param integer $id id of customer
     * @return CustomerEntity
     */
    public function fetchSingleById($id)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('id', $id);

        return $this->selectWith($select)->current();
    }
}
