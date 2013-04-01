<?php
namespace Ololz\Form\Fieldset;

use Zend\Form\Element;

/**
 * Base fieldset to search for matches
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
abstract class MatchSearchBase extends SearchBase
{
    public function __construct($name = null, $options = array())
    {
        if (is_null($name)) {
            $name = 'match_search';
        }

        parent::__construct($name, $options);
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getDateMin()
    {
        $value = new \DateTime;
        $value->sub(new \DateInterval('P7D'));

        $dateMin = new Element\Text;
        $dateMin->setLabel('Matches in between')
                ->setName('date_min')
                ->setValue($value->format('Y-m-d'));

        return $dateMin;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getDateMax()
    {
        $value = new \DateTime;

        $dateMax = new Element\Text;
        $dateMax->setLabel('and')
                ->setName('date_max')
                ->setValue($value->format('Y-m-d'));

        return $dateMax;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getChampion()
    {
        $champion = new Element\Text;
        $champion->setLabel('Champion')
                 ->setName('champion');

        return $champion;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getPosition()
    {
        $position = new Element\Text;
        $position->setLabel('Position')
                 ->setName('position');

        return $position;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getMap()
    {
        $map = new Element\Text;
        $map->setLabel('Map')
            ->setName('map');

        return $map;
    }
}