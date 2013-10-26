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
namespace Customer\Controller;

use Customer\Service\CustomerService;
use InvalidArgumentException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Index controller
 *
 * Handles the customer pages
 *
 * @package    Customer
 */
class IndexController extends AbstractActionController
{
    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * set the customer service
     *
     * @param CustomerService
     */
    public function setCustomerService(CustomerService $customerService)
    {
        $this->customerService = $customerService;

        return $this;
    }

    /**
     * Get the customer service
     *
     * @return CustomerService
     */
    public function getCustomerService()
    {
        if (!isset($this->customerService)) {
            throw new InvalidArgumentException('CustomerService was not set');
        }
        return $this->customerService;
    }

    /**
     * Handle customer list
     */
    public function indexAction()
    {
        return new ViewModel();
    }
}
