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
 * Customer module configuration
 *
 * @package    Customer
 */
return array(
    'router'       => array(
        'routes' => array(
            'customer' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/customer',
                    'defaults' => array(
                        'controller' => 'customer',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers'  => array(
        'factories' => array(
            'customer' => 'Customer\Controller\IndexControllerFactory',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Customer\Service\Customer' => 'Customer\Service\CustomerServiceFactory',
            'Customer\Table\Customer'   => 'Customer\Table\CustomerTableFactory',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
