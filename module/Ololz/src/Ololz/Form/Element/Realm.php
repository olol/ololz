<?php
namespace Ololz\Form\Element;

use Ololz\Mapper;

use Zend\Form\Element;

/**
 * Realm form element
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Realm extends Element\Select
{
    /**
     * @var \Ololz\Mapper\Summoner
     */
    protected $mapper;

    /**
     * {@inheritDoc}
     */
    public function __construct($name = null, $options = array())
    {
        if (is_null($name)) {
            $name = 'realm';
        }

        $this->setLabel('Realm')
             ->setAttribute('data-placeholder', 'Search realms...')
             ->setAttribute('multiple', true);

        parent::__construct($name, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function setValueOptions(array $options = null)
    {
        if (is_null($options) && $this->getMapper()) {
            $options = $this->getMapper()->getRealmsForList();
        } else if (is_null($options)) {
            $options = array();
        }

        return parent::setValueOptions($options);
    }

    /**
     * @param \Ololz\Mapper\Summoner    $mapper
     *
     * @return \Ololz\Form\Element\Summoner
     */
    public function setMapper(Mapper\Summoner $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * @return \Ololz\Mapper\Summoner
     */
    public function getMapper()
    {
        return $this->mapper;
    }
}
