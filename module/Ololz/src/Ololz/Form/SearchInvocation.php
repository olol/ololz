<?php
namespace Ololz\Form;

use Ololz\Form\Fieldset;

use Zend\Form\Element;

/**
 * Form to search for invocations
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class SearchInvocation extends SearchBase
{
    public function init()
    {
        $invocationSearchFieldset = new Fieldset\SearchInvocation;
        $invocationSearchFieldset->setUseAsBaseFieldset(true);
        $this->add($invocationSearchFieldset);

        parent::init();
    }
}