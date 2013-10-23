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
 * Tests configuration
 *
 * @package    Application
 */
return array(
    'modules'                 => array(
        'Application',
        'Customer',
    ),
    'module_listener_options' => array(
        'module_paths'             => array(
            APPLICATION_ROOT . '/module',
            APPLICATION_ROOT . '/vendor',
        ),
    ),
);
