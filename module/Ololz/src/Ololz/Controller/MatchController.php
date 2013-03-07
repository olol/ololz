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

class MatchController extends AbstractActionController
{
    /**
     * @var \Ololz\Service\Persist\Match
     */
    protected $service;

    /**
     * Public match page
     */
    public function indexAction()
    {
        $match = $this->getService()->getMapper()->find($this->params('match'));
        $teams = $match->getMatchTeams();

//        echo('<pre>');
//        \Doctrine\Common\Util\Debug::dump($match->getWinner());
//        die('</pre>' . "\n");

        return new ViewModel(array(
            'match'     => $match,
            'winner'    => $match->getWinner(),
            'loser'     => $match->getLoser(),
            'teams'     => $teams
        ) );
    }

    public function listAction()
    {
        // @todo paginator ?
//        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Array());
//        $paginator->setCurrentPageNumber($this->params('page'));

//        $criteria = array('active' => 1);
        $criteria = array();

        $matches = $this->getService()->getMapper()->findBy($criteria, 'date');

        return new ViewModel(array(
            'matches' => $matches
        ) );
    }

    /**
     * @return \Ololz\Service\Persist\Match
     */
    public function getService()
    {
        if (null === $this->service) {
            $this->setService($this->getServiceLocator()->get('Ololz\Service\Persist\Match'));
        }

        return $this->service;
    }

    /**
     * @param \Ololz\Service\Persist\Match   $service
     *
     * @return \Ololz\Controller\MatchController
     */
    public function setService(ServicePersist\Match $service)
    {
        $this->service = $service;

        return $this;
    }
}
