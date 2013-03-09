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
use Ololz\Service\Persist as ServiceChart;

use Zend\View\Model\ViewModel;

class ChampionController extends BaseController
{
    /**
     * @var \Ololz\Service\Persist\Champion
     */
    protected $service;

    /**
     * @var \Ololz\Service\Chart\Champion
     */
    protected $chartService;

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

    public function summonerAction()
    {
        $this->getViewHelper('HeadScript')->appendFile($this->getRequest()->getBasePath() . '/js/highcharts.js');

        $champion = $this->getService()->getMapper()->findOneByCode($this->params('champion'));
        $summoner = $this->getService('Summoner')->getMapper()->find($this->params('summoner'));

        $data = $this->getChartService('Invocation')->lastGamesOf($summoner, $champion);

        $chart = new \HighRollerColumnChart;
        $chart->title->text = 'Last games of ' . $summoner . ' with ' . $champion;
        $chart->plotOptions->column = array(
//            'stacking' => 'normal',
            'dataLabels'    => array(
                'enabled'   => true,
                'color'     => 'white'
            )
        );
        $chart->yAxis->min = 0;
        $chart->yAxis->title = array('text' => 'K D A');
        $chart->yAxis->stackLabels = array(
            'enabled'   => true,
            'style'     => array(
                'fontWeight'    => 'bold',
                'color'         => 'black'
            )
        );
        $chart->xAxis->categories = array_keys($data['kills']);

        foreach ($data as $dataType => $dataOfType) {
            $series = new \HighRollerSeries;
            $series->name = $dataType;
            foreach ($dataOfType as $data) {
                if (! is_null($data)) {
                    $series->addData($data);
                }
            }
            $chart->addSeries($series);
        }

        return new ViewModel(array(
            'summoner'  => $summoner,
            'champion'  => $champion,
            'chart'     => $chart
        ) );

    }

    /**
     * @param $serviceName  string
     *
     * @return \Ololz\Service\Persist\Champion
     */
    public function getService($serviceName = null)
    {
        if (! is_null($serviceName)) {
            return $this->getServiceLocator()->get('Ololz\Service\Persist\\' . ucfirst($serviceName));
        }

        if (is_null($this->service)) {
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

    /**
     * @param $serviceName  string
     *
     * @return \Ololz\Service\Chart\Champion
     */
    public function getChartService($serviceName = null)
    {
        if (! is_null($serviceName)) {
            return $this->getServiceLocator()->get('Ololz\Service\Chart\\' . ucfirst($serviceName));
        }

        if (is_null($this->chartService)) {
            $this->setChartService($this->getChartServiceLocator()->get('Ololz\Service\Chart\Champion'));
        }

        return $this->chartService;
    }

    /**
     * @param \Ololz\Service\Chart\Champion     $chartServiec
     *
     * @return \Ololz\Controller\ChampionController
     */
    public function setChartService(ServiceChart\Champion $chartServiec)
    {
        $this->chartService = $chartServiec;

        return $this;
    }
}
