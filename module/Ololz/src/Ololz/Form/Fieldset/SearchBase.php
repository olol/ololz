<?php
namespace Ololz\Form\Fieldset;

use Ololz\Form\Element as Element;

use Zend\Form\Element as ZFElement;
use Zend\ServiceManager\ServiceManager;

/**
 * Base fieldset to search for something
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
abstract class SearchBase extends Base
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     *
     * @return \Ololz\Form\Base
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    protected function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementLimit()
    {
        $limit = new ZFElement\Text;
        $limit->setLabel('max # of results')
              ->setName('limit')
              ->setValue(20)
              ->setAttribute('class', 'input-small');

        return $limit;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementOrderBy()
    {
        $orderBy = new ZFElement\Text;
        $orderBy->setLabel('Ordered by')
                ->setName('order_by');

        return $orderBy;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementOffset()
    {
        $offset = new ZFElement\Text;
        $offset->setLabel('Starting from result #')
               ->setName('offset')
               ->setAttribute('class', 'input-small');

        return $offset;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementDateMin()
    {
        $value = new \DateTime;
        $value->sub(new \DateInterval('P7D'));

        $dateMin = new ZFElement\Text;
        $dateMin->setLabel('Matches in between')
                ->setName('date_min')
                ->setValue($value->format('Y-m-d'))
                ->setAttributes(array(
                    'class'             => 'input-small',
                    'placeholder'       => $dateMin->getValue(),
                    'data-date-format'  => 'yyyy-mm-dd'
                ) );

        return $dateMin;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementDateMax()
    {
        $value = new \DateTime;

        $dateMax = new ZFElement\Text;
        $dateMax->setLabel('and')
                ->setName('date_max')
                ->setValue($value->format('Y-m-d'))
                ->setAttributes(array(
                    'class'             => 'input-small',
                    'placeholder'       => $dateMax->getValue(),
                    'data-date-format'  => 'yyyy-mm-dd'
                ) );

        return $dateMax;
    }

    /**
     * @return \Ololz\Form\Element\Summoner
     */
    public function getElementSummoner()
    {
        $summoner = new Element\Summoner;
        if ($this->getServiceManager()) {
            $summoner->setMapper($this->getServiceManager()->get('Ololz\Mapper\Summoner'))
                     ->setValueOptions();
        }

        return $summoner;
    }

    /**
     * @return \Ololz\Form\Element\Realm
     */
    public function getElementRealm()
    {
        $realm = new Element\Realm;
        if ($this->getServiceManager()) {
            $realm->setMapper($this->getServiceManager()->get('Ololz\Mapper\Summoner'))
                  ->setValueOptions();
        }

        return $realm;
    }

    /**
     * @return \Ololz\Form\Element\Champion
     */
    public function getElementChampion()
    {
        $champion = new Element\Champion;
        if ($this->getServiceManager()) {
            $champion->setMapper($this->getServiceManager()->get('Ololz\Mapper\Champion'))
                     ->setValueOptions();
        }

        return $champion;
    }

    /**
     * @return \Ololz\Form\Element\Position
     */
    public function getElementPosition()
    {
        $position = new Element\Position;
        if ($this->getServiceManager()) {
            $position->setMapper($this->getServiceManager()->get('Ololz\Mapper\Position'))
                     ->setValueOptions();
        }

        return $position;
    }

    /**
     * @return \Ololz\Form\Element\Map
     */
    public function getElementMap()
    {
        $map = new Element\Map;
        if ($this->getServiceManager()) {
            $map->setMapper($this->getServiceManager()->get('Ololz\Mapper\Map'))
                ->setValueOptions();
        }

        return $map;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementMatchType()
    {
        $matchType = new Element\MatchType;
        if ($this->getServiceManager()) {
            $matchType->setMapper($this->getServiceManager()->get('Ololz\Mapper\MatchType'))
                      ->setValueOptions();
        }

        return $matchType;
    }
}