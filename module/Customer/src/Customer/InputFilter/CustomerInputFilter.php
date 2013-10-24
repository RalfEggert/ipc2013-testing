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
namespace Customer\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Customer input filter
 *
 * InputFilter class to filter and validate customer data
 *
 * @package    Customer
 */
class CustomerInputFilter extends InputFilter
{
    /**
     * Init
     */
    public function init()
    {
        $this->add(
            array(
                'name'       => 'id',
                'required'   => true,
                'validators' => array(
                    array(
                        'name' => 'Int',
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'firstname',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToLower'),
                    array('name' => 'callback', 'options' => array('callback' => 'ucwords')),
                ),
                'validators' => array(
                    array(
                        'name'    => 'Alpha',
                        'options' => array('allowWhiteSpace' => true)
                    ),
                    array(
                        'name'    => 'StringLength',
                        'options' => array('min' => '3', 'max' => '64')
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'lastname',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToLower'),
                    array('name' => 'callback', 'options' => array('callback' => 'ucwords')),
                ),
                'validators' => array(
                    array(
                        'name'    => 'Alpha',
                        'options' => array('allowWhiteSpace' => true)
                    ),
                    array(
                        'name'    => 'StringLength',
                        'options' => array('min' => '3', 'max' => '64')
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'street',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToLower'),
                    array('name' => 'callback', 'options' => array('callback' => 'ucwords')),
                ),
                'validators' => array(
                    array(
                        'name'    => 'Alnum',
                        'options' => array('allowWhiteSpace' => true)
                    ),
                    array(
                        'name'    => 'StringLength',
                        'options' => array('min' => '3', 'max' => '64')
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'postcode',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'   => 'Postcode',
                        'locale' => 'de_DE',
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'city',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToLower'),
                    array('name' => 'callback', 'options' => array('callback' => 'ucwords')),
                ),
                'validators' => array(
                    array(
                        'name'    => 'Alpha',
                        'options' => array('allowWhiteSpace' => true)
                    ),
                    array(
                        'name'    => 'StringLength',
                        'options' => array('min' => '3', 'max' => '64')
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'country',
                'required'   => true,
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => array('de', 'at', 'ch'),
                        ),
                    ),
                ),
            )
        );
    }

}
