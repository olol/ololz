<?php
namespace Ololz\Form\Element;

use Ololz\Mapper;

use Zend\Form\Element;

/**
 * MatchType form element
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class MatchType extends Element\Select
{
    /**
     * @var \Ololz\Mapper\MatchType
     */
    protected $mapper;

    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        if (is_null($name)) {
            $name = 'match_type';
        }

        $this->setLabel('MatchType')
             ->setAttribute('data-placeholder', 'Search match types...')
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
     * @param \Ololz\Mapper\MatchType    $mapper
     *
     * @return \Ololz\Form\Element\MatchType
     */
    public function setMapper(Mapper\MatchType $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * @return \Ololz\Mapper\MatchType
     */
    public function getMapper()
    {
        return $this->mapper;
    }
}
