<?php
namespace Ololz\Form;

use Ololz\Form\Fieldset;

use Zend\Form\Element;
use Zend\ServiceManager\ServiceManager;

/**
 * Base form to search
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
abstract class SearchBase extends Base
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     *
     * @return \Ololz\Form\Base
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    protected function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function init()
    {
        $this->setAttribute('id', 'search');

        $searchButton = new Element\Button('search');
        $searchButton->setLabel('Search');
        $this->add($searchButton);
    }
}