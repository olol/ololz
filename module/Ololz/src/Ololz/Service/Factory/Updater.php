<?php

namespace Ololz\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Log\Logger;

/**
 * Updater factory
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Updater implements FactoryInterface
{
    /**
     * @var string|array
     */
    protected $type;

    public function __construct($type)
    {
        $this->type = ucfirst($type);
    }

    /**
     * {@inheritDoc}
     *
     * @return \Ololz\Service\Updater\Updater
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (is_array($this->type)) {
            // Chain
        }

        $updaterClass = '\Ololz\Service\Updater\\' . $this->type;

        if (! class_exists($updaterClass)) {
            throw new \InvalidArgumentException('The class ' . $updaterClass . ' doest not exist and can not be created.');
        }

        $logger = new Logger(array(
            'writers' => array(array(
                'name' => 'mock',
            ) )
        ) );

        $service = new $updaterClass;
        $service->setServiceManager($serviceLocator);
        $service->setLogger($logger);
        return $service;
    }
}
