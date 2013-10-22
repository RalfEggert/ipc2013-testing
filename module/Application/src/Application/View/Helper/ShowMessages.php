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
namespace Application\View\Helper;

use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Helper\AbstractHelper;

/**
 * Show messages view helper
 *
 * Outputs all messages from FlashMessenger and view
 *
 * @package    Application
 */
class ShowMessages extends AbstractHelper
{
    /**
     * FlashMessenger
     *
     * @var FlashMessenger
     */
    protected $flashMessenger;

    /**
     * Constructor
     *
     * @param  FlashMessenger $flashMessenger
     */
    public function __construct(FlashMessenger $flashMessenger)
    {
        $this->setFlashMessenger($flashMessenger);
    }

    /**
     * Outputs message depending on flag
     *
     * @return string
     */
    public function __invoke()
    {
        // get messages
        $messages = array_unique(
            array_merge(
                $this->flashMessenger->getMessages(),
                $this->flashMessenger->getCurrentMessages()
            )
        );

        // initialize output
        $output = '';

        // loop through messages
        foreach ($messages as $message) {
            // create output
            $output .= '<div class="alert alert-success">';
            $output .= '<button class="close" data-dismiss="alert" type="button">×</button>';
            $output .= '<h2>' . $message . '</h2>';
            $output .= '</div>';
        }

        // clear messages
        $this->flashMessenger->clearMessages();
        $this->flashMessenger->clearCurrentMessages();

        // return output
        return $output . "\n";
    }

    /**
     * Sets FlashMessenger
     *
     * @param  FlashMessenger $flashMessenger
     *
     * @return AbstractHelper
     */
    public function setFlashMessenger(FlashMessenger $flashMessenger = null)
    {
        $this->flashMessenger = $flashMessenger;
        return $this;
    }

    /**
     * Returns FlashMessenger
     *
     * @return FlashMessenger
     */
    public function getFlashMessenger()
    {
        return $this->flashMessenger;
    }
}
