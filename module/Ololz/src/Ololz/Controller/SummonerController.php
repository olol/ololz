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
        $this->getViewHelper('HeadScript')->appendFile($this->getRequest()->getBasePath() . '/assets/ololz/summoner/index.js');

        $summoner = $this->getService()->getMapper()->find($this->params('summoner'));
        $lastWeek = new \DateTime;
        $lastWeek->sub(new \DateInterval('P7D'));
        $championsPlayedThisWeek = $this->getServiceLocator()->get('Ololz\Service\Persist\Champion')->getMapper()->findDistinctBySummonerAndMatchDate($summoner, $lastWeek);

        return new ViewModel(array(
            'summoner'      => $summoner,
            'champions'     => $championsPlayedThisWeek
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

    public function invocationsAction()
    {
        $summoner       = $this->getService()->getMapper()->find($this->params('summoner'));
        $invocations    = $this->getServiceLocator()->get('Ololz\Service\Persist\Invocation')->getMapper()->findBySummoner($summoner, null, 10);

        $viewModel = new ViewModel(array(
            'summoner'      => $summoner,
            'invocations'   => $invocations
        ) );
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function championAction()
    {
        $this->getViewHelper('HeadScript')->appendFile($this->getRequest()->getBasePath() . '/js/highcharts.js');

        $champion = $this->getService('Champion')->getMapper()->findOneByCode($this->params('champion'));
        $summoner = $this->getService()->getMapper()->find($this->params('summoner'));

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
     * @return \Ololz\Service\Persist\Base
     */
    public function getService($serviceName = null)
    {
        if (! is_null($serviceName)) {
            return $this->getServiceLocator()->get('Ololz\Service\Persist\\' . ucfirst($serviceName));
        }

        if (is_null($this->service)) {
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

    /**
     * @param $serviceName  string
     *
     * @return \Ololz\Service\Chart\Summoner
     */
    public function getChartService($serviceName = null)
    {
        if (! is_null($serviceName)) {
            return $this->getServiceLocator()->get('Ololz\Service\Chart\\' . ucfirst($serviceName));
        }

        if (is_null($this->chartService)) {
            $this->setChartService($this->getChartServiceLocator()->get('Ololz\Service\Chart\Summoner'));
        }

        return $this->chartService;
    }

    /**
     * @param \Ololz\Service\Chart\Summoner     $chartService
     *
     * @return \Ololz\Controller\SummonerController
     */
    public function setChartService(ServiceChart\Summoner $chartService)
    {
        $this->chartService = $chartService;

        return $this;
    }
}
