<?php

namespace Ololz\Mapper;

use Ololz\Entity;

use Doctrine\ORM\EntityManager;

/**
 * Invocation mapper
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Invocation extends Base
{
    /**
     * @param \Doctrine\ORM\EntityManager   $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct('Ololz\Entity\Invocation', $em);
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
    public function findBySummonerQuery(Entity\Summoner $summoner, $criteria = null, $orderBy = null, $limit = null, $offset = null)
    {
        if (is_null($orderBy)) {
            $orderBy = array('m.date' => 'DESC');
        }

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('i')
            ->from($this->getEntityName(), 'i')
            ->leftJoin('i.matchTeam', 'mt')
            ->leftJoin('mt.match', 'm')
            ->leftJoin('i.summoner', 's')
            ->andWhere('s.id = :summoner')
            ->setParameter('summoner', $summoner->getId())
        ;

        return $this->restrictQuery($query, $criteria, $orderBy, $limit, $offset);
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
    public function findBySummoner(Entity\Summoner $summoner, $criteria, $orderBy = null, $limit = null, $offset = null)
    {
        $query = $this->findBySummonerQuery($summoner, $criteria, $orderBy, $limit, $offset);

        return $query->getQuery()->getResult();
    }

    /**
     * The query to find last matches since the given date of the given
     * summoner.
     *
     * @param \Ololz\Entity\Summoner    $summoner
     * @param \DateTime                 $dateStart
     * @param \DateTime                 $dateEnd
     * @param array                     $criteria
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findBySummonerAndMatchDateQuery(Entity\Summoner $summoner, \DateTime $dateStart = null, \DateTime $dateEnd = null, $criteria = null, $orderBy = null, $limit = null, $offset = null)
    {
        $query = $this->findBySummonerQuery($summoner, $criteria, $orderBy, $limit, $offset);

        if ($dateStart instanceof \DateTime) {
            $query->andWhere('m.date >= :dateStart')
                  ->setParameter('dateStart', $dateStart->format('Y-m-d H:i:s'));
        }

        if ($dateEnd instanceof \DateTime) {
            $query->andWhere('m.date <= :dateEnd')
                  ->setParameter('dateEnd', $dateEnd->format('Y-m-d H:i:s'));
        }

        return $query;
    }

    /**
     * The query to find last matches since the given date of the given
     * summoner.
     *
     * @param \Ololz\Entity\Summoner    $summoner
     * @param \DateTime                 $dateStart
     * @param \DateTime                 $dateEnd
     * @param array                     $criteria
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return array
     */
    public function findBySummonerAndMatchDate(Entity\Summoner $summoner, \DateTime $dateStart = null, \DateTime $dateEnd = null, $criteria = null, $orderBy = null, $limit = null, $offset = null)
    {
        $query = $this->findBySummonerAndMatchDateQuery($summoner, $dateStart, $dateEnd, $criteria, $orderBy, $limit, $offset);

        return $query->getQuery()->getResult();
    }
}
