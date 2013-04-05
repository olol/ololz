<?php
namespace Ololz\Form;

use Ololz\Form\Fieldset;

use Zend\Form\Element;

/**
 * Base form to search
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
abstract class SearchBase extends Base
{
    public function init()
    {
        $this->setAttribute('id', 'search');

        $searchButton = new Element\Button('search');
        $searchButton->setLabel('Search');
        $this->add($searchButton);
    }
}