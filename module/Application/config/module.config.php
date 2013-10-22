<?php
/**
 * Unit-Testing einer Zend Framework 2 Anwendung
 *
 * Zend Framework Session auf der International PHP Conference 2013 in München
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Ralf Eggert <r.eggert@travello.de>
 * @link       http://www.ralfeggert.de/
 */

/**
 * Application module configuration
 *
 * @package    Application
 */
return array(
    'router'          => array(
        'routes' => array(
            'home'    => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'imprint' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/impressum',
                    'defaults' => array(
                        'controller' => 'about',
                        'action'     => 'imprint',
                    ),
                ),
            ),
        ),
    ),

    'controllers'     => array(
        'invokables' => array(
            'index' => 'Application\Controller\IndexController',
            'about' => 'Application\Controller\AboutController',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Session\Config' => 'Zend\Session\Service\SessionConfigFactory',
        ),
    ),

    'view_helpers'    => array(
        'invokables' => array(
            'pageTitle' => 'Application\View\Helper\PageTitle',
            'showForm'  => 'Application\View\Helper\ShowForm',
            'date'      => 'Application\View\Helper\Date',
        ),
        'factories'  => array(
            'showMessages' => 'Application\View\Helper\ShowMessagesFactory',
        ),
    ),

    'view_manager'    => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => include __DIR__ . '/../view/template_map.php',
        'template_path_stack'      => array(
            __DIR__ . '/../view',
        ),
    ),

    'session_config'  => array(
        'save_path' => realpath(APPLICATION_ROOT . '/data/session'),
        'name'      => 'ZFS_SESSION',
    ),
);
