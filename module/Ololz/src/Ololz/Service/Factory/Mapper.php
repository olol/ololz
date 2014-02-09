<?php

namespace Ololz\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

/**
 * Mapper factory
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Mapper implements FactoryInterface
{
    protected $mapperName;

    /**
     * @param string $mapperName
     */
    public function __construct($mapperName)
    {
        $this->mapperName = ucfirst($mapperName);
    }

    /**
     * {@inheritDoc}
     *
     * @return \Ololz\Mapper\Base
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $mapperClass = 'Ololz\Mapper\\' . $this->mapperName;;

        if (! class_exists($mapperClass)) {
            throw new \InvalidArgumentException('The class ' . $mapperClass . ' doest not exist and can not be created.');
        }

        /* @var $mapper \Ololz\Mapper\Base */
        $mapper = new $mapperClass($em);
        $mapper->setServiceManager($serviceLocator);

        $mapper->init();

        return $mapper;
    }
}
