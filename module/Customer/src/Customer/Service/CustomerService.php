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
namespace Customer\Service;

use InvalidArgumentException;

/**
 * Customer sercice
 *
 * Service class to handle the customer
 *
 * @package    Customer
 */
class CustomerService
{
    protected $customerTable;

    public function setCustomerTable($customerTable)
    {
        $this->customerTable = $customerTable;
    }

    public function getCustomerTable()
    {
        if (!isset($this->customerTable)) {
            throw new InvalidArgumentException('CustomerTable was not set');
        }
        return $this->customerTable;
    }
}
