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

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Index controller factory
 *
 * Creates the index controller for the customer module
 *
 * @package    Customer
 */
class IndexControllerFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $controllerLoader)
    {
        $serviceLocator     = $controllerLoader->getServiceLocator();
        $formElementManager = $serviceLocator->get('FormElementManager');

        $service = $serviceLocator->get('Customer\Service\Customer');
        $form    = $formElementManager->get('Customer\Form\Customer');

        $controller = new IndexController();
        $controller->setCustomerService($service);
        $controller->setCustomerForm($form);

        return $controller;
    }
}