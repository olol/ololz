<?php
namespace Ololz\Service\Persist;

use Ololz\Mapper;

use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\EventManager;

/**
 * Base persist service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
abstract class Base
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @var \Zend\EventManager\EventManager
     */
    protected $eventManager;

    /**
     * @var Mapper\Base
     */
    protected $mapper;

    /**
     *
     * @param \Zend\ServiceManager\ServiceManager   $serviceManager
     * @return \Ololz\Service\Updater
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @return \Zend\EventManager\EventManager
     */
    public function getEventManager()
    {
        if (is_null($this->eventManager)) {
            $this->setEventManager(new \Zend\EventManager\EventManager(get_class($this)));
            if ($this->getServiceManager() && $this->getServiceManager()->has('Ololz\Service\EventManager')) {
                $this->getEventManager()->setSharedManager($this->getServiceManager()->has('Ololz\Service\EventManager'));
            }
        }

        return $this->eventManager;
    }

    /**
     * @param \Zend\EventManager\EventManager   $eventManager
     *
     * @return \Ololz\Service\Persist\Base
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;

        return $this;
    }

    /**
     * @return \Ololz\Mapper\Base
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param \Ololz\Mapper\Base    $mapper
     *
     * @return \Ololz\Service\Persist\Base
     */
    public function setMapper(Mapper\Base $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * Has to be called in the factory after all depencies have been injected.
     */
    public function init() {}

    /**
     * Save entity
     *
     * @param array|\Ololz\Entity\Base  $entity
     * @param bool                      $flush
     *
     * @return \Ololz\Entity\Base
     */
    public function save($entity, $flush = false)
    {
        return $this->getMapper()->save($entity, $flush);
    }

    /**
     * Delete entity
     *
     * @param string|array|\Ololz\Entity\Base    $entity
     * @param bool                              $flush
     *
     * @return \Ololz\Entity\Base
     */
    public function delete($entity, $flush = false)
    {
        return $this->getMapper()->  delete($entity, $flush);
    }
}