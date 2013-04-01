<?php

namespace Ololz\Mapper;

use Ololz\Entity;

use Doctrine\ORM\EntityManager;

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
     *
     * @return \Ololz\Entity\Champion
     */
    public function findOneByCode($code)
    {
        return parent::findOneBy(array('code' => $code));
    }

    /**
     * Find matches of the given summoner.
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
            $orderBy = 'c.name';
        }

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from($this->getEntityName(), 'c')
            ->leftJoin('c.invocations', 'i')
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
     * The query to find last played champions since the given date of the given
     * summoner.
     *
     * @param \Ololz\Entity\Summoner    $summoner
     * @param \DateTime                 $dateStart
     * @param \DateTime                 $dateEnd
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return QueryBuilder
     */
    public function findBySummonerAndMatchDateQuery(Entity\Summoner $summoner, \DateTime $dateStart, \DateTime $dateEnd = null, $orderBy = null, $limit = null, $offset = null)
    {
        $query = $this->findBySummonerQuery($summoner, $orderBy, $limit, $offset)
            ->leftJoin('i.matchTeam', 'mt')
            ->leftJoin('mt.match', 'm')
            ->andWhere('m.date > :dateStart')
            ->setParameter('dateStart', $dateStart->format('Y-m-d H:i:s'))
        ;

        if ($dateEnd instanceof \DateTime) {
            $query->andWhere('m.date <= :dateEnd')
                  ->setParameter('dateEnd', $dateEnd->format('Y-m-d H:i:s'));
        }

        return $query;
    }

    /**
     * The query to find last played champions since the given date of the given
     * summoner.
     *
     * @param \Ololz\Entity\Summoner    $summoner
     * @param \DateTime                 $dateStart
     * @param \DateTime                 $dateEnd
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return array
     */
    public function findBySummonerAndMatchDate(Entity\Summoner $summoner, \DateTime $dateStart, \DateTime $dateEnd = null, $orderBy = null, $limit = null, $offset = null)
    {
        $query = $this->findBySummonerAndMatchDateQuery($summoner, $dateStart, $dateEnd, $orderBy, $limit, $offset);

        return $query->getQuery()->getResult();
    }

    /**
     * The query to find last played champions since the given date of the given
     * summoner.
     *
     * @param \Ololz\Entity\Summoner    $summoner
     * @param \DateTime                 $dateStart
     * @param \DateTime                 $dateEnd
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return QueryBuilder
     */
    public function findDistinctBySummonerAndMatchDateQuery(Entity\Summoner $summoner, \DateTime $dateStart, \DateTime $dateEnd = null, $orderBy = null, $limit = null, $offset = null)
    {
        $query = $this->findBySummonerAndMatchDateQuery($summoner, $dateStart, $dateEnd, $orderBy, $limit, $offset)
            ->distinct()
        ;

        return $query;
    }

    /**
     * The query to find last played champions since the given date of the given
     * summoner.
     *
     * @param \Ololz\Entity\Summoner    $summoner
     * @param \DateTime                 $dateStart
     * @param \DateTime                 $dateEnd
     * @param string|array              $orderBy
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return array
     */
    public function findDistinctBySummonerAndMatchDate(Entity\Summoner $summoner, \DateTime $dateStart, \DateTime $dateEnd = null, $orderBy = null, $limit = null, $offset = null)
    {
        $query = $this->findDistinctBySummonerAndMatchDateQuery($summoner, $dateStart, $dateEnd, $orderBy, $limit, $offset);

        return $query->getQuery()->getResult();
    }
}