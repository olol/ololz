<?php

namespace Ololz\Mapper;

use Doctrine\ORM\EntityManager;

/**
 * Source mapper
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Source extends Base
{
    /**
     * @param \Doctrine\ORM\EntityManager   $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct('Ololz\Entity\Source', $em);
    }

    /**
     * @param string        $code
     *
     * @return \Ololz\Entity\Source
     */
    public function findOneByCode($code)
    {
        return parent::findOneBy(array('code' => $code));
    }
}