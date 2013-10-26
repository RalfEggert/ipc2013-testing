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

use Customer\InputFilter\CustomerInputFilter;
use Customer\Table\CustomerTable;
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
    /**
     * @var CustomerTable
     */
    protected $customerTable;

    /**
     * @var CustomerInputFilter
     */
    protected $customerFilter;

    /**
     * Set Customer Table
     *
     * @param CustomerTable $customerTable
     */
    public function setCustomerTable(CustomerTable $customerTable)
    {
        $this->customerTable = $customerTable;
    }

    /**
     * Get Customer Table
     *
     * @return CustomerTable
     * @throws \InvalidArgumentException
     */
    public function getCustomerTable()
    {
        if (!isset($this->customerTable)) {
            throw new InvalidArgumentException('CustomerTable was not set');
        }
        return $this->customerTable;
    }

    /**
     * Set Customer Filter
     *
     * @param CustomerInputFilter $customerFilter
     */
    public function setCustomerFilter(CustomerInputFilter $customerFilter)
    {
        $this->customerFilter = $customerFilter;
    }

    /**
     * Get Customer Filter
     *
     * @return CustomerInputFilter
     * @throws \InvalidArgumentException
     */
    public function getCustomerFilter()
    {
        if (!isset($this->customerFilter)) {
            throw new InvalidArgumentException('CustomerFilter was not set');
        }
        return $this->customerFilter;
    }
}
