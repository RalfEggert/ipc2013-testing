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
 * namespace definition and usage
 */
namespace Application\Listener;

use Locale;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

/**
 * Application listener
 *
 * Listens on application level
 *
 * @package    Application
 */
class ApplicationListener implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Attach to an event manager
     *
     * @param  EventManagerInterface $events
     * @param  integer               $priority
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_RENDER,
            array($this, 'renderLayoutSegments'),
            -100
        );
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH,
            array($this, 'setupLocalization'),
            -100
        );
    }

    /**
     * Detach all our listeners from the event manager
     *
     * @param  EventManagerInterface $events
     *
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Listen to the "render" event and render additional layout segments
     *
     * @param  MvcEvent $e
     *
     * @return null
     */
    public function renderLayoutSegments(EventInterface $e)
    {
        // get view Model
        $viewModel = $e->getViewModel();
        /* @var $viewModel ViewModel */

        // only for normal View Models
        if (!$viewModel instanceof JsonModel) {
            // add an additional header segment to layout
            $header = new ViewModel();
            $header->setTemplate('layout/header');
            $viewModel->addChild($header, 'header');

            // add an additional footer segment to layout
            $footer = new ViewModel();
            $footer->setTemplate('layout/footer');
            $viewModel->addChild($footer, 'footer');
        }

        // return response
        return $e->getResponse();
    }

    /**
     * Listen to the "dispatch" event and setup the localization
     *
     * @param  MvcEvent $e
     *
     * @return null
     */
    public function setupLocalization(EventInterface $e)
    {
        // get service manager
        $serviceManager = $e->getApplication()->getServiceManager();
        $viewManager = $serviceManager->get('viewmanager');

        // set locale
        Locale::setDefault('de_DE');

        // setup currency view helper
        $currencyHelper = $viewManager->getRenderer()->plugin('currencyformat');
        $currencyHelper->setCurrencyCode('EUR');
        $currencyHelper->setShouldShowDecimals(true);
    }
}
