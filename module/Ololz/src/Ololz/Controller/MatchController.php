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

class MatchController extends BaseController
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

        return new ViewModel(array(
            'match'     => $match,
            'winner'    => $match->getWinner(),
            'loser'     => $match->getLoser(),
            'teams'     => $match->getMatchTeams()
        ) );
    }

    public function listAction()
    {
        $this->getViewHelper('HeadScript')->appendFile($this->getRequest()->getBasePath() . '/assets/ololz/match/list.js');
    }

    public function matchesAction()
    {
        $matches = $this->getServiceLocator()->get('Ololz\Service\Search\Match')
            ->setParams($this->params()->fromPost())
            ->setDateStart(! is_null($this->params()->fromPost('date_min')) ? new \DateTime($this->params()->fromPost('date_min') . ' 00:00:00') : null)
            ->setDateEnd(! is_null($this->params()->fromPost('date_max')) ? new \DateTime($this->params()->fromPost('date_max') . ' 23:59:59') : null)

            ->search()
        ;

        $viewModel = new ViewModel(array(
            'matches'   => $matches
        ) );
        $viewModel->setTerminal(true);

        return $viewModel;
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
