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
namespace Customer\Entity;

/**
 * Customer entity
 *
 * Entity class to represent customers
 *
 * @package    Customer
 */
class CustomerEntity
{
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $street;
    protected $postcode;
    protected $city;
    protected $country;

    /**
     * Set Id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get Id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Firstname
     *
     * @param integer $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get Firstname
     *
     * @return integer
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set Lastname
     *
     * @param integer $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get Lastname
     *
     * @return integer
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set Street
     *
     * @param integer $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get Street
     *
     * @return integer
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set Postcode
     *
     * @param integer $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * Get Postcode
     *
     * @return integer
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set City
     *
     * @param integer $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get City
     *
     * @return integer
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set Country
     *
     * @param integer $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Get Country
     *
     * @return integer
     */
    public function getCountry()
    {
        return $this->country;
    }
}
