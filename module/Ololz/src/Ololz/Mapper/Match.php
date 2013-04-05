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
     * @return \Doctrine\ORM\QueryBuilder
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

    /**
     * The query to find last matches since the given dates.
     *
     * @param \DateTime                 $dateStart
     * @param \DateTime                 $dateEnd
     * @param array                     $criteria
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByMatchDateQuery(\DateTime $dateStart = null, \DateTime $dateEnd = null, $criteria = null, $orderBy = null, $limit = null, $offset = null)
    {
        if (is_null($orderBy)) {
            $orderBy = array('m.date' => 'DESC');
        }

        $query = $this->getEntityManager()->createQueryBuilder()
            ->distinct()
            ->select('m')
            ->from($this->getEntityName(), 'm')
            ->leftJoin('m.matchTeams', 'mt')
            ->leftJoin('mt.invocations', 'i')
            ->leftJoin('i.summoner', 's')
        ;

        if ($dateStart instanceof \DateTime) {
            $query->andWhere('m.date >= :dateStart')
                  ->setParameter('dateStart', $dateStart->format('Y-m-d H:i:s'));
        }

        if ($dateEnd instanceof \DateTime) {
            $query->andWhere('m.date <= :dateEnd')
                  ->setParameter('dateEnd', $dateEnd->format('Y-m-d H:i:s'));
        }

        return $this->restrictQuery($query, $criteria, $orderBy, $limit, $offset);
    }

    /**
     * The query to find last matches since the given dates.
     *
     * @param \DateTime                 $dateStart
     * @param \DateTime                 $dateEnd
     * @param array                     $criteria
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return array
     */
    public function findByMatchDate(\DateTime $dateStart = null, \DateTime $dateEnd = null, $criteria = null, $orderBy = null, $limit = null, $offset = null)
    {
        $query = $this->findByMatchDateQuery($dateStart, $dateEnd, $criteria, $orderBy, $limit, $offset);

        return $query->getQuery()->getResult();
    }
}