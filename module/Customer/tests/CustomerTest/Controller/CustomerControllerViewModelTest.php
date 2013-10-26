<?php
/**
 * Unit-Testing einer Zend Framework 2 Anwendung
 *
 * Zend Framework Session auf der International PHP Conference 2013 in München
 *
 * @package    CustomerTest
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Ralf Eggert <r.eggert@travello.de>
 * @link       http://www.ralfeggert.de/
 */

/**
 * namespace definition and usage
 */
namespace CustomerTest\Controller;

use PHPUnit_Framework_TestCase;

/**
 * ModuleTest
 *
 * Tests the Module class of the Customer Module
 *
 * @package    CustomerTest
 */
class CustomerControllerViewModelTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test if index action can be accessed
     */
    public function testIndexActionCanBeAccessed()
    {
        return;
        
        $data = array(
            array(
                'id'        => 42,
                'firstname' => 'Manfred',
                'lastname'  => 'Mustermann',
                'street'    => 'Am Testen 123',
                'postcode'  => '54321',
                'city'      => 'Musterhausen',
                'country'   => 'de',
            ),
            array(
                'id'        => 43,
                'firstname' => 'Manuela',
                'lastname'  => 'Musterfrau',
                'street'    => 'Am Mustern 987',
                'postcode'  => '98765',
                'city'      => 'Testhausen',
                'country'   => 'de',
            )
        );

        $customerHydrator = new CustomerHydrator();

        $expectedListData = array();

        foreach ($data as $row) {

            $expectedListData[$row['id']] = new CustomerEntity();

            $customerHydrator->hydrate($row, $expectedListData[$row['id']]);
        }

        $mockCustomerService = $this->getMockBuilder('Customer\Service\CustomerService')->getMock();
        $mockCustomerService->expects($this->any())->method('fetchList')->will($this->returnValue($expectedListData));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Customer\Service\CustomerService', $mockCustomerService);

        $result = $this->dispatch('/customer');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Customer');
        $this->assertControllerName('customer');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('customer');

        foreach ($expectedListData as $customerEntity) {
            /** @var $customerEntity CustomerEntity */
            $this->assertContains($customerEntity->getFirstname(), $this->getResponse());
            $this->assertContains($customerEntity->getLastname(), $this->getResponse());
            $this->assertContains($customerEntity->getStreet(), $this->getResponse());
            $this->assertContains($customerEntity->getPostcode(), $this->getResponse());
            $this->assertContains($customerEntity->getCity(), $this->getResponse());
            $this->assertContains($customerEntity->getCountry(), $this->getResponse());
        }
    }
}