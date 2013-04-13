<?php

namespace Ololz\Mapper;

use Doctrine\ORM\EntityManager;

/**
 * Map mapper
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Map extends Base
{
    /**
     * @param \Doctrine\ORM\EntityManager   $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct('Ololz\Entity\Map', $em);
    }

    /**
     * {@inheritedDoc}
     */
    public function findAll($orderBy = null)
    {
        if (is_null($orderBy)) {
            $orderBy = array('name' => 'ASC');
        }

        return parent::findAll($orderBy);
    }

    /**
     * Find all maps for a list
     *
     * @param string|array  $orderBy
     *
     * @return array
     */
    public function findAllForList($orderBy = null)
    {
        $list = array();

        foreach ($this->findAll($orderBy) as $map) {
            $list[$map->getId()] = (string) $map;
        }

        return $list;
    }

    /**
     * @param string        $code
     *
     * @return \Ololz\Entity\Map
     */
    public function findOneByCode($code)
    {
        return parent::findOneBy(array('code' => $code));
    }
}