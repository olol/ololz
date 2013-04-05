<?php
namespace Ololz\Form\Fieldset;

use Zend\ServiceManager\ServiceManager;
use Zend\Form\Fieldset;
use Zend\Form\Fieldset\HydratorInterface;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Base fieldset
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
abstract class Base extends Fieldset implements InputFilterProviderInterface
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    private $serviceManager;

    /**
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     *
     * @return \Ololz\Form\Fieldset\Base
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    private function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * The extending class should take care of this by lazy loading a doctrine
     * hydrator if the fieldset referes to an entity
     *
     * @return \Zend\Stdlib\Hydrator\HydratorInterface
     */
    public function getHydrator()
    {
        return parent::getHydrator();
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array();
    }
}