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

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Customer service factory
 *
 * Creates the customer service for the customer module
 *
 * @package    Customer
 */
class CustomerServiceFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $inputFilterManager = $serviceLocator->get('InputFilterManager');

        $table  = $serviceLocator->get('Customer\Table\Customer');
        $filter = $inputFilterManager->get('Customer\CustomerFilter');

        $service = new CustomerService();
        $service->setCustomerTable($table);
        $service->setCustomerFilter($filter);

        return $service;
    }
}