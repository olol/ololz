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

class SummonerController extends BaseController
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
        $summoner       = $this->getService()->getMapper()->find($this->params('summoner'));
        $last10Matches  = $this->getServiceLocator()->get('Ololz\Service\Persist\Match')->getMapper()->findBySummoner($summoner, null, 10);
        $lastWeek = new \DateTime;
        $lastWeek->sub(new \DateInterval('P7D'));
        $championsPlayedThisWeek = $this->getServiceLocator()->get('Ololz\Service\Persist\Champion')->getMapper()->findDistinctBySummonerAndMatchDate($summoner, $lastWeek);

        return new ViewModel(array(
            'summoner'  => $summoner,
            'matches'   => $last10Matches,
            'champions' => $championsPlayedThisWeek
        ) );
    }

    public function listAction()
    {
        // @todo paginator ?
//        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Array());
//        $paginator->setCurrentPageNumber($this->params('page'));

        $summoners = $this->getService()->getMapper()->findBy(array('active' => true), 'name');

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
