<?php

namespace Ololz\Mapper;

use Ololz\Entity;

use Doctrine\ORM\EntityManager;

/**
 * Summoner mapper
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Summoner extends Base
{
    /**
     * @param \Doctrine\ORM\EntityManager   $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct('Ololz\Entity\Summoner', $em);
    }

    /**
     * @return array
     */
    public function getRealmsForList()
    {
        $list = array();

        foreach (Entity\Summoner::getRealms() as $realm) {
            $list[$realm] = strtoupper($realm);
        }

        return $list;
    }

    /**
     * @param bool          $active
     * @param string|array  $orderBy
     * @param int           $limit
     * @param int           $offset
     *
     * @return array
     */
    public function findByActive($active, $orderBy = null, $limit = null, $offset = null)
    {
        if (is_null($orderBy)) {
            $orderBy = array('name' => 'ASC');
        }

        return parent::findBy(array('active' => $active), $orderBy, $limit, $offset);
    }

    /**
     * @param bool          $active
     * @param string|array  $orderBy
     * @param int           $limit
     * @param int           $offset
     *
     * @return array
     */
    public function findByActiveForList($active, $orderBy = null, $limit = null, $offset = null)
    {
        $list = array();

        foreach ($this->findByActive($active, $orderBy, $limit, $offset) as $summoner) {
            $list[$summoner->getId()] = (string) $summoner . ' (' . $summoner->getRealm() . ')';
        }

        return $list;
    }
}