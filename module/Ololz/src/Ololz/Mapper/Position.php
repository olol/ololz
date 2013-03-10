<?php

namespace Ololz\Mapper;

use Doctrine\ORM\EntityManager;

/**
 * Position mapper
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Position extends Base
{
    /**
     * @param \Doctrine\ORM\EntityManager   $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct('Ololz\Entity\Position', $em);
    }

    /**
     * @param string        $code
     *
     * @return \Ololz\Entity\Position
     */
    public function findOneByCode($code)
    {
        return parent::findOneBy(array('code' => $code));
    }

    /**
     * @param string        $keyField field name or null for id
     * @param string        $valueField field name or 'toString' or null for whole entity
     * @param array         $criteria
     * @param string|array  $orderBy
     * @param int           $limit
     * @param int           $offset
     *
     * @return array
     */
    public function findWithKey(
            $keyField = null,
            $valueField = 'toString',
            $criteria = array(),
            $orderBy = array('name' => 'ASC'),
            $limit = null,
            $offset = null
    ) {
        $found = array();

        $keyGetter = $this->getterForField($keyField);
        $keyGetter ? $keyGetter : 'getId';
        $valueGetter = null;
        if ($valueField == 'toString') {
            $valueGetter = 'getDisplayedLabel';
        } else {
            $valueGetter = $valueField ? $this->getterForField($valueField) : null;
        }

        foreach (parent::findBy($criteria, $orderBy, $limit, $offset) as $entity) {
            $found[$entity->$keyGetter()] = $valueGetter ? $entity->$valueGetter() : $entity;
        }

        return $found;
    }
}