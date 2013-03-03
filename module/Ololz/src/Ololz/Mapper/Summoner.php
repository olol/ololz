<?php

namespace Ololz\Mapper;

use \Doctrine\ORM\EntityManager;

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
     * @param bool          $active
     * @param string|array  $orderBy
     * @param int           $limit
     * @param int           $offset
     *
     * @return array
     */
    public function findByActive($active, $orderBy = null, $limit = null, $offset = null)
    {
        return parent::findBy(array('active' => $active), $orderBy, $limit, $offset);
    }
}