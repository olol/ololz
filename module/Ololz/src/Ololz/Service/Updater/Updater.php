<?php

namespace Ololz\Service\Updater;

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

}
