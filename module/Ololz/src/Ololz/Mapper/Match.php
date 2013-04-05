<?php

namespace Ololz\Mapper;

use Ololz\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

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
     *
     * @return \Ololz\Entity\Match
     */
    public function findOneByHash($hash)
    {
        return parent::findOneBy(array('hash' => $hash));
    }

    /**
     * The query to find matches of the given summoner.
     *
     * @param \Ololz\Entity\Summoner    $summoner
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return QueryBuilder
     */
    public function findBySummonerQuery(Entity\Summoner $summoner, $orderBy = null, $limit = null, $offset = null)
    {
        if (is_null($orderBy)) {
            $orderBy = array('m.date' => 'DESC');
        }

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('m')
            ->from($this->getEntityName(), 'm')
            ->leftJoin('m.matchTeams', 'mt')
            ->leftJoin('mt.invocations', 'i')
            ->leftJoin('i.summoner', 's')
            ->andWhere('s.id = :summoner')
            ->setParameter('summoner', $summoner->getId())
        ;

        return $this->restrictQuery($query, null, $orderBy, $limit, $offset);
    }

    /**
     * Find matches of the given summoner.
     *
     * @param \Ololz\Entity\Summoner    $summoner
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return array
     */
    public function findBySummoner(Entity\Summoner $summoner, $orderBy = null, $limit = null, $offset = null)
    {
        $query = $this->findBySummonerQuery($summoner, $orderBy, $limit, $offset);

        return $query->getQuery()->getResult();
    }
}