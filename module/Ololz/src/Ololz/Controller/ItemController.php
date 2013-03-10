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

class ItemController extends BaseController
{
    /**
     * @var \Ololz\Service\Persist\Item
     */
    protected $service;

    /**
     * Public item page
     */
    public function indexAction()
    {
        $item = $this->getService()->getMapper()->find($this->params('item'));

        return new ViewModel(array(
            'item'  => $item,
        ) );
    }

    public function listAction()
    {
        // @todo paginator ?
//        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Array());
//        $paginator->setCurrentPageNumber($this->params('page'));

//        $criteria = array('active' => 1);
        $criteria = array();

        $items = $this->getService()->getMapper()->findBy($criteria, 'name');

        return new ViewModel(array(
            'items' => $items
        ) );
    }

    /**
     * @return \Ololz\Service\Persist\Item
     */
    public function getService()
    {
        if (null === $this->service) {
            $this->setService($this->getServiceLocator()->get('Ololz\Service\Persist\Item'));
        }

        return $this->service;
    }

    /**
     * @param \Ololz\Service\Persist\Item   $service
     *
     * @return \Ololz\Controller\ItemController
     */
    public function setService(ServicePersist\Item $service)
    {
        $this->service = $service;

        return $this;
    }
}
