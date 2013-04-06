<?php
namespace Ololz\Form\Element;

use Ololz\Mapper;

use Zend\Form\Element;

/**
 * Champion form element
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Champion extends Element\Select
{
    /**
     * @var \Ololz\Mapper\Champion
     */
    protected $mapper;

    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        if (is_null($name)) {
            $name = 'champion';
        }

        $this->setLabel('Champion')
             ->setAttribute('data-placeholder', 'Search champions...')
             ->setAttribute('multiple', true);

        parent::__construct($name, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function setValueOptions(array $options = null)
    {
        if (is_null($options) && $this->getMapper()) {
            $options = $this->getMapper()->findAllForList();
        } else if (is_null($options)) {
            $options = array();
        }

        return parent::setValueOptions($options);
    }

    /**
     * @param \Ololz\Mapper\Champion    $mapper
     *
     * @return \Ololz\Form\Element\Champion
     */
    public function setMapper(Mapper\Champion $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * @return \Ololz\Mapper\Champion
     */
    public function getMapper()
    {
        return $this->mapper;
    }
}
