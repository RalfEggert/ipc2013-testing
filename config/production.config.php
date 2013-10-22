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
 * Application configuration
 *
 * @package    Application
 */
return array(
    'modules'                 => array(
        'Application',
    ),
    'module_listener_options' => array(
        'config_glob_paths'        => array(
            'config/autoload/{,*.}{production}.php',
        ),
        'module_paths'             => array(
            './module',
            './vendor',
        ),
        'cache_dir'                => './data/cache/application',
        'config_cache_enabled'     => true,
        'config_cache_key'         => 'module_config_cache',
        'module_map_cache_enabled' => true,
        'module_map_cache_key'     => 'module_map_cache',
    ),
);
