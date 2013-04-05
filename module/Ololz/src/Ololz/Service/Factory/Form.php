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
class Form implements FactoryInterface
{
    protected $formName;

    /**
     * @param string $formName
     */
    public function __construct($formName)
    {
        $this->formName = ucfirst($formName);
    }

    /**
     * {@inheritDoc}
     *
     * @return \Ololz\Form\Base|\Ololz\Form\Fieldset\Base
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $formClass = 'Ololz\Form\\' . $this->formName;;

        if (! class_exists($formClass)) {
            throw new \InvalidArgumentException('The class ' . $formClass . ' doest not exist and can not be created.');
        }

        /* @var $form \Ololz\Form\Base */
        $form = new $formClass();
        $form->setServiceManager($serviceLocator);

        $form->init();

        return $form;
    }
}
