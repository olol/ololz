<?php

namespace Ololz\Service\Chart;

use Ololz\Entity;

/**
 * Invocation chart service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Invocation extends Base
{
    private function prepareFieldsForQuery($fields)
    {
        $specificFields = array('kda' =>  function() {
            return null;
            return '((i.kills + i.assists) / i.deaths) AS kda';
        } );

        foreach ($fields as $key => $field) {
            if (!array_key_exists($field, $specificFields)) {
                $fields[$key] = 'i.' . $field;
            } else {
                $sField = $specificFields[$field]();
                if ($sField) {
                    $fields[$key] = $sField;
                } else {
                    unset($fields[$key]);
                }
            }
        }

        return $fields;
    }

    /**
     * @param \Ololz\Entity\Summoner    $summoner
     * @param \Ololz\Entity\Champion    $champion
     * @param array                     $fields
     * @param int                       $limit
     * @param int                       $offset
     *
     * @return array
     */
    public function lastGamesOf(Entity\Summoner $summoner, Entity\Champion $champion, $fields = null, $limit = 10, $offset = 0)
    {
        if (is_null($fields)) {
            $fields = array('kills', 'deaths', 'assists', 'kda');//, 'gold', 'minions');
        }
        $fieldsForQuery = array_merge($this->prepareFieldsForQuery($fields), array('m.date'));

        $query = $this->getMapper()->getEntityManager()->createQueryBuilder()
            ->select($fieldsForQuery)
            ->from($this->getMapper()->getEntityName(), 'i')
            ->leftJoin('i.matchTeam', 'mt')
            ->leftJoin('mt.match', 'm')
            ->andWhere('i.summoner = :summoner')
            ->andWhere('i.champion = :champion')
            ->setParameter('summoner', $summoner->getId())
            ->setParameter('champion', $champion->getId())
        ;

        $query = $this->getMapper()->restrictQuery($query, null, array('i.id', 'DESC'), $limit, $offset);

        $result = array_reverse($query->getQuery()->getArrayResult());

        return $this->separateFieldsDataByDate($result, $fields);
    }
}