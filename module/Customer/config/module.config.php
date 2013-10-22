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
    'router'          => array(
        'routes' => array(
            'home'    => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/customer',
                    'defaults' => array(
                        'controller' => 'customer-index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'controllers'     => array(
        'invokables' => array(
            'customer-index' => 'Customer\Controller\IndexController',
        ),
    ),
);
