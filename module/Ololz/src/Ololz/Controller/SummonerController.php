<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ololz\Controller;

use Ololz\Service\Persist as ServicePersist;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class SummonerController extends AbstractActionController
{
    /**
     * @var \Ololz\Service\Persist\Summoner
     */
    protected $service;

    /**
     * Public summoner page
     */
    public function indexAction()
    {
        $summoner = $this->getService()->getMapper()->find($this->params('summoner'));
        $invocations = $summoner->getInvocations();
        $matches = array();
        foreach ($invocations as $invocation) {
            $matches[] = $invocation->getMatchTeam()->getMatch();
        }

//        echo('<pre>');
//        \Doctrine\Common\Util\Debug::dump($matches);
//        die('</pre>' . "\n");

        return new ViewModel(array(
            'summoner'  => $summoner,
            'matches'   => $matches
        ) );
    }

    public function listAction()
    {
        // @todo paginator ?
//        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Array());
//        $paginator->setCurrentPageNumber($this->params('page'));

//        $criteria = array('active' => 1);
        $criteria = array();

        $summoners = $this->getService()->getMapper()->findBy($criteria, 'name');

        return new ViewModel(array(
            'summoners' => $summoners
        ) );
    }

    /**
     * @return \Ololz\Service\Persist\Summoner
     */
    public function getService()
    {
        if (null === $this->service) {
            $this->setService($this->getServiceLocator()->get('Ololz\Service\Persist\Summoner'));
        }

        return $this->service;
    }

    /**
     * @param \Ololz\Service\Persist\Summoner   $service
     *
     * @return \Ololz\Controller\SummonerController
     */
    public function setService(ServicePersist\Summoner $service)
    {
        $this->service = $service;

        return $this;
    }
}
