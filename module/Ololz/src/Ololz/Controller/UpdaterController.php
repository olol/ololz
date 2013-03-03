<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ololz\Controller;

use Ololz\Entity;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UpdaterController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function championAction()
    {
        $service = $this->getServiceLocator()->get('Ololz\Service\Updater\Champion');
        $service->update();
        $writer = $service->getLogger()->getWriters()->current();

        $variables = array(
            'name' => 'Champions',
            'logs' => $writer->events
        );

        return new ViewModel($variables);
    }

    public function itemAction()
    {
        $service = $this->getServiceLocator()->get('Ololz\Service\Updater\Item');
        $service->update();
        $writer = $service->getLogger()->getWriters()->current();

        $variables = array(
            'name' => 'Items',
            'logs' => $writer->events
        );

        return new ViewModel($variables);
    }

    public function spellAction()
    {
        $service = $this->getServiceLocator()->get('Ololz\Service\Updater\Spell');
        $service->update();
        $writer = $service->getLogger()->getWriters()->current();

        $variables = array(
            'name' => 'Spells',
            'logs' => $writer->events
        );

        return new ViewModel($variables);
    }

    public function matchAction()
    {
        $service = $this->getServiceLocator()->get('Ololz\Service\Updater\Match');
        $service->update();
        $writer = $service->getLogger()->getWriters()->current();

        $variables = array( 
            'name' => 'Matches',
            'logs' => $writer->events
        );

        return new ViewModel($variables);
    }
}
