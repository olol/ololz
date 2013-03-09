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

class ChampionController extends AbstractActionController
{
    /**
     * @var \Ololz\Service\Persist\Champion
     */
    protected $service;

    /**
     * Public champion page
     */
    public function indexAction()
    {
        $champion = $this->getService()->getMapper()->findOneByCode($this->params('champion'));

        if (! $champion) {
            throw new \InvalidArgumentException('Champion ' . $this->params('champion') . ' does not exist.');
        }

        return new ViewModel(array(
            'champion'  => $champion,
        ) );
    }

    public function listAction()
    {
        // @todo paginator ?
//        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Array());
//        $paginator->setCurrentPageNumber($this->params('page'));

//        $criteria = array('active' => 1);
        $criteria = array();

        $champions = $this->getService()->getMapper()->findBy($criteria, 'name');

        return new ViewModel(array(
            'champions' => $champions
        ) );
    }

    /**
     * @return \Ololz\Service\Persist\Champion
     */
    public function getService()
    {
        if (null === $this->service) {
            $this->setService($this->getServiceLocator()->get('Ololz\Service\Persist\Champion'));
        }

        return $this->service;
    }

    /**
     * @param \Ololz\Service\Persist\Champion   $service
     *
     * @return \Ololz\Controller\ChampionController
     */
    public function setService(ServicePersist\Champion $service)
    {
        $this->service = $service;

        return $this;
    }
}
