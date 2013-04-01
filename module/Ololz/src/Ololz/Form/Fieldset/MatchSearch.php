<?php
namespace Ololz\Form\Fieldset;

use Ololz\Entity;

use Zend\Form\Element;

/**
 * Fieldset to search for matches
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class MatchSearch extends MatchSearchBase
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->add($this->getDateMin())
             ->add($this->getDateMax())
             ->add($this->getChampion())
             ->add($this->getPosition())
             ->add($this->getMap())

             ->add($this->getLimit())
        ;
    }
}