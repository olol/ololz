<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ololz;

use Ololz\Service\Factory as ServiceFactory;
use Ololz\View;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements
    AutoloaderProviderInterface,
//    BootstrapListenerInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
            ),

            'factories' => array(
                'Ololz\Mapper\Champion'     => new ServiceFactory\Mapper('Champion'),
                'Ololz\Mapper\Invocation'   => new ServiceFactory\Mapper('Invocation'),
                'Ololz\Mapper\Item'         => new ServiceFactory\Mapper('Item'),
                'Ololz\Mapper\Map'          => new ServiceFactory\Mapper('Map'),
                'Ololz\Mapper\Mapping'      => new ServiceFactory\Mapper('Mapping'),
                'Ololz\Mapper\Match'        => new ServiceFactory\Mapper('Match'),
                'Ololz\Mapper\MatchTeam'    => new ServiceFactory\Mapper('MatchTeam'),
                'Ololz\Mapper\MatchType'    => new ServiceFactory\Mapper('MatchType'),
                'Ololz\Mapper\Position'     => new ServiceFactory\Mapper('Position'),
                'Ololz\Mapper\Spell'        => new ServiceFactory\Mapper('Spell'),
                'Ololz\Mapper\Source'       => new ServiceFactory\Mapper('Source'),
                'Ololz\Mapper\Summoner'     => new ServiceFactory\Mapper('Summoner'),

                'Ololz\Form\SearchInvocation'   => new ServiceFactory\Form('SearchInvocation'),
                'Ololz\Form\SearchMatch'        => new ServiceFactory\Form('SearchMatch'),

                'Ololz\Service\Persist\Champion'    => new ServiceFactory\ServicePersist('Champion'),
                'Ololz\Service\Persist\Invocation'  => new ServiceFactory\ServicePersist('Invocation'),
                'Ololz\Service\Persist\Item'        => new ServiceFactory\ServicePersist('Item'),
                'Ololz\Service\Persist\Map'         => new ServiceFactory\ServicePersist('Map'),
                'Ololz\Service\Persist\Mapping'     => new ServiceFactory\ServicePersist('Mapping'),
                'Ololz\Service\Persist\Match'       => new ServiceFactory\ServicePersist('Match'),
                'Ololz\Service\Persist\MatchTeam'   => new ServiceFactory\ServicePersist('MatchTeam'),
                'Ololz\Service\Persist\MatchType'   => new ServiceFactory\ServicePersist('MatchType'),
                'Ololz\Service\Persist\Position'    => new ServiceFactory\ServicePersist('Position'),
                'Ololz\Service\Persist\Spell'       => new ServiceFactory\ServicePersist('Spell'),
                'Ololz\Service\Persist\Source'      => new ServiceFactory\ServicePersist('Source'),
                'Ololz\Service\Persist\Summoner'    => new ServiceFactory\ServicePersist('Summoner'),

                'Ololz\Service\Chart\Champion'      => new ServiceFactory\ServiceChart('Champion'),
                'Ololz\Service\Chart\Invocation'    => new ServiceFactory\ServiceChart('Invocation'),

                'Ololz\Service\Search\Invocation'   => new ServiceFactory\ServiceSearch('Invocation'),

                'Ololz\Service\Updater\Champion'    => new ServiceFactory\Updater('Champion'),
                'Ololz\Service\Updater\Item'        => new ServiceFactory\Updater('Item'),
                'Ololz\Service\Updater\Match'       => new ServiceFactory\Updater('Match'),
                'Ololz\Service\Updater\Spell'       => new ServiceFactory\Updater('Spell'),

                'Ololz\Service\Logger'              => function() {
                    $logger = new \Zend\Log\Logger(array(
                        'writers' => array(array(
                            'name'      => 'stream',
                            'options'   => array(
                                'stream'    => __DIR__ . '/../../../../data/log/' . date('Y-m-d') . '.log'
                            )
                        ) )
                    ) );

                    return $logger;
                }
            ),

            'aliases' => array(
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'championPictureUrl' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\Champion\PictureUrl;
                    // @todo handle default source via config
                    $viewHelper->setDefaultSource($locator->get('Ololz\Mapper\Source')->findOneByCode('lolking'))
                               ->setMappingMapper($locator->get('Ololz\Mapper\Mapping'));
                    return $viewHelper;
                },
                'itemPictureUrl' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\Item\PictureUrl;
                    // @todo handle default source via config
                    $viewHelper->setDefaultSource($locator->get('Ololz\Mapper\Source')->findOneByCode('lolking'))
                               ->setMappingMapper($locator->get('Ololz\Mapper\Mapping'));
                    return $viewHelper;
                },
                'spellPictureUrl' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\Spell\PictureUrl;
                    // @todo handle default source via config
                    $viewHelper->setDefaultSource($locator->get('Ololz\Mapper\Source')->findOneByCode('lolking'))
                               ->setMappingMapper($locator->get('Ololz\Mapper\Mapping'));
                    return $viewHelper;
                },
                'formSearchMatch' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\Form\Form;
                    $viewHelper->setForm($locator->get('Ololz\Form\SearchMatch'));
                    return $viewHelper;
                },
                'formSearchInvocation' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\Form\Form;
                    $viewHelper->setForm($locator->get('Ololz\Form\SearchInvocation'));
                    return $viewHelper;
                },
            ),
        );
    }
}
