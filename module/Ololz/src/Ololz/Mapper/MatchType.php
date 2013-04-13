<?php

namespace Ololz\Mapper;

use Doctrine\ORM\EntityManager;

/**
 * MatchType mapper
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class MatchType extends Base
{
    /**
     * @param \Doctrine\ORM\EntityManager   $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct('Ololz\Entity\MatchType', $em);
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
     * Find all match types for a list
     *
     * @param string|array  $orderBy
     *
     * @return array
     */
    public function findAllForList($orderBy = null)
    {
        $list = array();

        foreach ($this->findAll($orderBy) as $matchType) {
            $list[$matchType->getId()] = (string) $matchType;
        }

        return $list;
    }

    /**
     * @param string        $code
     *
     * @return \Ololz\Entity\MatchType
     */
    public function findOneByCode($code)
    {
        return parent::findOneBy(array('code' => $code));
    }
}