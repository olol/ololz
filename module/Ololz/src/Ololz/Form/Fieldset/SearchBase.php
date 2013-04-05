<?php
namespace Ololz\Form\Fieldset;

use Zend\Form\Element;

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
     * @return \Zend\Form\Element\Text
     */
    public function getElementLimit()
    {
        $limit = new Element\Text;
        $limit->setLabel('max # of results')
              ->setName('limit')
              ->setValue(20);

        return $limit;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementOrderBy()
    {
        $orderBy = new Element\Text;
        $orderBy->setLabel('Ordered by')
                ->setName('order_by');

        return $orderBy;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementOffset()
    {
        $offset = new Element\Text;
        $offset->setLabel('Starting from result #')
               ->setName('offset');

        return $offset;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementDateMin()
    {
        $value = new \DateTime;
        $value->sub(new \DateInterval('P7D'));

        $dateMin = new Element\Text;
        $dateMin->setLabel('Matches in between')
                ->setName('date_min')
                ->setValue($value->format('Y-m-d'))
                ->setAttribute('placeholder', $dateMin->getValue());

        return $dateMin;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementDateMax()
    {
        $value = new \DateTime;

        $dateMax = new Element\Text;
        $dateMax->setLabel('and')
                ->setName('date_max')
                ->setValue($value->format('Y-m-d'))
                ->setAttribute('placeholder', $dateMax->getValue());

        return $dateMax;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementSummoner()
    {
        $summoner = new Element\Text;
        $summoner->setLabel('Summoner')
                 ->setName('summoner')
                 ->setAttribute('placeholder', 'summoner\'s name...');

        return $summoner;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementRealm()
    {
        $realm = new Element\Text;
        $realm->setLabel('Realm')
              ->setName('realm')
              ->setAttribute('placeholder', 'br, eune, euw, kr, na');

        return $realm;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementChampion()
    {
        $champion = new Element\Text;
        $champion->setLabel('Champion')
                 ->setName('champion')
                 ->setAttribute('placeholder', 'graves, cho-gath, lee-sin...');

        return $champion;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementPosition()
    {
        $position = new Element\Text;
        $position->setLabel('Position')
                 ->setName('position')
                 ->setAttribute('placeholder', 'top, mid, adc, support, jungle');

        return $position;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementMap()
    {
        $map = new Element\Text;
        $map->setLabel('Map')
            ->setName('map')
            ->setAttribute('placeholder', 'summoner-s-rift, crystal-scar...');

        return $map;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getElementMatchType()
    {
        $matchType = new Element\Text;
        $matchType->setLabel('Match type')
                  ->setName('match_type')
                  ->setAttribute('placeholder', 'normal-5v5, ranked-solo-5v5...');

        return $matchType;
    }
}