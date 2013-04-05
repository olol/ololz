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
class SearchMatch extends SearchBase
{
    public function __construct($name = null, $options = array())
    {
        if (is_null($name)) {
            $name = 'search_match';
        }

        parent::__construct($name, $options);

        $this->add($this->getElementDateMin())
             ->add($this->getElementDateMax())
             ->add($this->getElementChampion())
             ->add($this->getElementPosition())
             ->add($this->getElementMap())
             ->add($this->getElementMatchType())

             ->add($this->getElementLimit())
        ;
    }
}