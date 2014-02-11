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

    /**
     * @var string
     */
    protected $source;

    public function __construct($type, $source = null)
    {
        $this->type = ucfirst($type);
        $this->source = $source;
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

        // If source is not given at instantiation, take it from config file
        if (is_null($this->source)) {
            $configuration = $serviceLocator->get('Configuration');
            $this->source = isset($configuration['ololz']['updater'][strtolower($this->type)]['source']) ? $configuration['ololz']['updater'][strtolower($this->type)]['source'] : 'lolking';
        }
        if (is_null($this->source)) {
            throw new \Exception("Don't forget to put the source you want to update from (lolking, mobafire) in the configuration file. It should be there by default but maybe you overrid it ?");
        }

        $updaterClass = '\Ololz\Service\Updater\\' . ucfirst($this->type) . '\Source\\' . ucfirst($this->source);

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
        $service->setSource($serviceLocator->get('Ololz\Mapper\Source')->findOneByCode($this->source));

        return $service;
    }
}
