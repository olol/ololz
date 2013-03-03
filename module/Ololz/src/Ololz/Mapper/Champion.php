<?php

namespace Ololz\Mapper;

use \Doctrine\ORM\EntityManager;

/**
 * Champion mapper
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Champion extends Base
{
    /**
     * @param \Doctrine\ORM\EntityManager   $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct('Ololz\Entity\Champion', $em);
    }

    /**
     * @param string        $code
     * @param string|array  $orderBy
     * @param int           $limit
     * @param int           $offset
     *
     * @return \Ololz\Entity\Champion
     */
    public function findOneByCode($code, $orderBy = null, $limit = null, $offset = null)
    {
        return parent::findOneBy(array('code' => $code), $orderBy, $limit, $offset);
    }
}