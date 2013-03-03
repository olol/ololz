<?php

namespace Ololz\Mapper;

use \Doctrine\ORM\EntityManager;

/**
 * Match mapper
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Match extends Base
{
    /**
     * @param \Doctrine\ORM\EntityManager   $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct('Ololz\Entity\Match', $em);
    }

    /**
     * @param string        $hash
     * @param string|array  $orderBy
     * @param int           $limit
     * @param int           $offset
     *
     * @return \Ololz\Entity\Match
     */
    public function findOneByHash($hash, $orderBy = null, $limit = null, $offset = null)
    {
        return parent::findOneBy(array('hash' => $hash), $orderBy, $limit, $offset);
    }
}