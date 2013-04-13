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

use Zend\View\Model\ViewModel;

class UpdaterController extends BaseController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function championAction()
    {
        $updater = $this->getServiceLocator()->get('Ololz\Service\Updater\Champion');
        $updater->update();
        $writer = $updater->getLogger()->getWriters()->current();

        $variables = array(
            'name' => 'Champions',
            'logs' => $writer->events
        );

        return new ViewModel($variables);
    }

    public function itemAction()
    {
        $updater = $this->getServiceLocator()->get('Ololz\Service\Updater\Item');
        $updater->update();
        $writer = $updater->getLogger()->getWriters()->current();

        $variables = array(
            'name' => 'Items',
            'logs' => $writer->events
        );

        return new ViewModel($variables);
    }

    public function spellAction()
    {
        $updater = $this->getServiceLocator()->get('Ololz\Service\Updater\Spell');
        $updater->update();
        $writer = $updater->getLogger()->getWriters()->current();

        $variables = array(
            'name' => 'Spells',
            'logs' => $writer->events
        );

        return new ViewModel($variables);
    }

    public function matchAction()
    {
        $updater = $this->getServiceLocator()->get('Ololz\Service\Updater\Match');
        $updater->update();
        $writer = $updater->getLogger()->getWriters()->current();

        $variables = array(
            'name' => 'Matches',
            'logs' => $writer->events
        );

        return new ViewModel($variables);
    }

    public function summonerAction()
    {
        if (! $this->params()->fromQuery('summoner')) {
            throw new \InvalidArgumentException('Missing summoner');
        }

        $summoner = $this->getServiceLocator()->get('Ololz\Service\Persist\Summoner')->getMapper()->find($this->params()->fromQuery('summoner'));

        if (! $summoner instanceof Entity\Summoner || ($summoner instanceof Entity\Summoner && ! $summoner->getActive())) {
            throw new \InvalidArgumentException('Wrong summoner');
        }

        $updater = $this->getServiceLocator()->get('Ololz\Service\Updater\Summoner');
        $updater->setSummoner($summoner);
        $updater->update();
        $matchWriter = $updater->getMatchUpdater()->getLogger()->getWriters()->current();

        $variables = array(
            'name'        => 'Summoner',
            'summoner'    => $summoner,
            'matchesLogs' => $matchWriter->events
        );

        return new ViewModel($variables);
    }
}
