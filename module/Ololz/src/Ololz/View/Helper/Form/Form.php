<?php

namespace Ololz\View\Helper\Form;

use Ololz\Form\Base;
use Zend\View\Helper\AbstractHelper;

class Form extends AbstractHelper
{
    /**
     * @var \Ololz\Form\Base
     */
    protected $form;

    /**
     * @param string    $elementName
     *
     * @return \Ololz\Form\Base
     */
    public function __invoke($elementName = null)
    {
        if ($this->getForm()->has((string) $elementName)) {

            return $this->getForm()->get((string) $elementName);
        }

        return $this->getForm();
    }

    /**
     * @return \Ololz\Form\Base
     */
    protected function getForm()
    {
        return $this->form;
    }

    /**
     * @param  \Ololz\Form\MatchSearch  $form
     *
     * @return \Ololz\View\Helper\Form\Form
     */
    public function setForm(Base $form)
    {
        $this->form = $form;

        return $this;
    }
}
