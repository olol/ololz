<?php

namespace Ololz\View\Helper\Form;

use Ololz\Form\MatchSearch as FormMatchSearch;
use Zend\View\Helper\AbstractHelper;

class MatchSearch extends AbstractHelper
{
    /**
     * @var \Ololz\Form\MatchSearch
     */
    protected $form;

    /**
     * @param string    $elementName
     *
     * @return \Ololz\Form\MatchSearch
     */
    public function __invoke($elementName = null)
    {
        if ($this->getForm()->has((string) $elementName)) {

            return $this->getForm()->get((string) $elementName);
        }

        return $this->getForm();
    }

    /**
     * @return \Ololz\Form\MatchSearch
     */
    protected function getForm()
    {
        return $this->form;
    }

    /**
     * @param  \Ololz\Form\MatchSearch  $form
     *
     * @return \Ololz\View\Helper\Form\MatchSearch
     */
    public function setForm(FormMatchSearch $form)
    {
        $this->form = $form;

        return $this;
    }
}
