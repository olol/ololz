<?php
namespace Ololz\Form;

use Ololz\Form\Fieldset;

use Zend\Form\Element;

/**
 * Form to search for matches
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class MatchSearch extends Base
{
    public function init()
    {
        $this->setAttribute('id', 'search');

        $matchSearchFieldset = new Fieldset\MatchSearch;
        $matchSearchFieldset->setUseAsBaseFieldset(true);
        $this->add($matchSearchFieldset);

        $searchButton = new Element\Button('search');
        $searchButton->setLabel('Search');
        $this->add($searchButton);
    }
}