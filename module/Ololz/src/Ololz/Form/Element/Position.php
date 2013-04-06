<?php
namespace Ololz\Form\Element;

use Ololz\Mapper;

use Zend\Form\Element;

/**
 * Position form element
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Position extends Element\Select
{
    /**
     * @var \Ololz\Mapper\Position
     */
    protected $mapper;

    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        if (is_null($name)) {
            $name = 'position';
        }

        $this->setLabel('Position')
             ->setAttribute('data-placeholder', 'Search positions...')
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
     * @param \Ololz\Mapper\Position    $mapper
     *
     * @return \Ololz\Form\Element\Position
     */
    public function setMapper(Mapper\Position $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * @return \Ololz\Mapper\Position
     */
    public function getMapper()
    {
        return $this->mapper;
    }
}
