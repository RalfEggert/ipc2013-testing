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
namespace Customer\Form;

use Zend\Form\Form;

/**
 * Customer form
 *
 * Form class to create and update customer data
 *
 * @package    Customer
 */
class CustomerForm extends Form
{
    /**
     * Init
     */
    public function init()
    {
        $this->add(
            array(
                'type' => 'hidden',
                'name' => 'id',
            )
        );

        $this->add(
            array(
                'type'       => 'Text',
                'name'       => 'firstname',
                'options'    => array(
                    'label' => 'Vorname',
                ),
                'attributes' => array(
                    'class' => 'span5',
                ),
            )
        );
    }
}
