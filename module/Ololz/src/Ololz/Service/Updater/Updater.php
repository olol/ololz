<?php

namespace Ololz\Service\Updater;

use Ololz\Entity;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Log\Logger;

/**
 * Updater service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Updater implements ServiceManagerAwareInterface
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @var \Zend\Log\Logger
     */
    protected $logger;

    /**
     * @var \Ololz\Entity\Source
     */
    protected $source;

    /**
     *
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
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
     * @param \Zend\Log\Logger $logger
     *
     * @return \Ololz\Service\Updater\Updater
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return \Zend\Log\Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param \Ololz\Entity\Source $source
     *
     * @return \Ololz\Service\Updater\Updater
     */
    public function setSource(Entity\Source $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return \Ololz\Entity\Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $serviceName
     *
     * @return \Ololz\Service\Persist\Base
     */
    public function getService($serviceName)
    {
        return $this->getServiceManager()->get('Ololz\Service\Persist' . ucfirst($serviceName));
    }

    /**
     * @param string $updaterName
     *
     * @return \Ololz\Service\Updater\Updater
     */
    public function getUpdater($updaterName)
    {
        return $this->getServiceManager()->get('Ololz\Service\Updater' . ucfirst($updaterName));
    }
}
