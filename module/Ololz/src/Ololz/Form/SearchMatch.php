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
class SearchMatch extends SearchBase
{
    public function init()
    {
        $matchSearchFieldset = new Fieldset\SearchMatch;
        $matchSearchFieldset->setUseAsBaseFieldset(true);
        $this->add($matchSearchFieldset);

        parent::init();
    }
}