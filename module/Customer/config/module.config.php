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
            'customer' => array(
                'type'          => 'Literal',
                'options'       => array(
                    'route'    => '/customer',
                    'defaults' => array(
                        'controller' => 'customer',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'action' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'       => '/:action[/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9_-]*',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'controllers'     => array(
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

    'form_elements' => array(
        'invokables' => array(
            'Customer\Form\Customer'    => 'Customer\Form\CustomerForm',
        ),
    ),

    'input_filters' => array(
        'invokables' => array(
            'Customer\CustomerFilter'   => 'Customer\InputFilter\CustomerInputFilter',
        ),
    ),

    'view_manager'    => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
