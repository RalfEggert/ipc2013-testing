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

use Zend\Db\Adapter\AdapterInterface;
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
        parent::__construct('customers', $adapter);
    }
}
