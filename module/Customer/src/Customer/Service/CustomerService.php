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

use Customer\Entity\CustomerEntity;
use Customer\Hydrator\CustomerHydrator;
use Customer\InputFilter\CustomerInputFilter;
use Customer\Table\CustomerTable;
use InvalidArgumentException;
use Zend\Db\Adapter\Exception\InvalidQueryException;

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

    /**
     * Fetch list of customers
     *
     * @param integer $country country code
     * @return array
     */
    public function fetchList($country = null)
    {
        $result = array();

        foreach ($this->getCustomerTable()->fetchList($country) as $customerEntity) {
            $result[$customerEntity->getId()] = $customerEntity;
        }

        return $result;
    }

    /**
     * Fetch single by id
     *
     * @param varchar $id
     * @return CustomerEntity
     */
    public function fetchSingleById($id)
    {
        return $this->getCustomerTable()->fetchSingleById($id);
    }

    /**
     * Save a customer
     *
     * @param array $data input data
     * @param integer $id id of customer entry
     *
     * @return CustomerEntity|false
     */
    public function save(array $data, $id = null)
    {
        // get mode
        $mode = (!$id) ? 'insert' : 'update';

        // get customer
        $customerEntity = ($mode == 'insert') ? new CustomerEntity() : $this->fetchSingleById($id);

        // get filter and set data
        $filter = $this->getCustomerFilter();
        $filter->setData($data);

        // check for invalid data
        if (!$filter->isValid()) {
            return false;
        }

        /** @var CustomerHydrator $hydrator */
        $hydrator = new CustomerHydrator();
        $hydrator->hydrate($data, $customerEntity);

        // insert new customer
        try {
            if ($mode == 'insert') {
                $this->getCustomerTable()->insertCustomer($customerEntity);

                // get last insert value
                $id = $this->getCustomerTable()->getLastInsertValue();
            } else {
                $this->getCustomerTable()->updateCustomer($customerEntity);
            }
        } catch (InvalidQueryException $e) {
            return false;
        }

        // reload customer
        $customerEntity = $this->fetchSingleById($id);

        // return entity
        return $customerEntity;
    }

    /**
     * Delete existing customer
     *
     * @param integer $id customer id
     * @return boolean
     */
    public function delete($id)
    {
        // fetch customer entity
        $customerEntity = $this->fetchSingleById($id);

        // check customer
        if (!$customerEntity) {
            return false;
        }

        // delete existing customer
        try {
            $result = $this->getCustomerTable()->deleteCustomer($customerEntity);
        } catch (InvalidQueryException $e) {
            return false;
        }

        // return result
        return true;
    }
}
