<?php
namespace Ololz\Service\Search;

use Ololz\Entity;

/**
 * Match search service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Match extends Base
{
    /**
     * @var \DateTime
     */
    protected $dateStart;

    /**
     * @var \DateTime
     */
    protected $dateEnd;

    /**
     * @return \Ololz\Form\MatchSearch
     */
    public function getForm()
    {
        if (is_null($this->form)) {
            $this->setForm($this->getServiceManager()->get('Ololz\Form\MatchSearch'));
        }

        return $this->form;
    }

    /**
     * @param \DateTime $dateStart
     *
     * @return \Ololz\Service\Search\Invocation
     */
    public function setDateStart(\DateTime $dateStart = null)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime $dateEnd
     *
     * @return \Ololz\Service\Search\Invocation
     */
    public function setDateEnd(\DateTime $dateEnd = null)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->setMappedFields(array('champion' => 'i.champion', 'summoner' => 'i.summoner', 'realm' => 's.realm', 'map' => 'm.map', 'match_type' => 'm.matchType'));
    }

    /**
     * {@inheritDoc}
     */
    public function search()
    {
        $query = $this->getService()->getMapper()->findByMatchDateQuery(
            $this->getDateStart(),
            $this->getDateEnd(),
            $this->getCriteria(),
            $this->getOrderBy(),
            $this->getLimit(),
            $this->getOffset()
        );

//        //  Champions are in andWhere, not a IN - so we hack here until a better way to do that
//        $params = $this->getParams();
//        if (array_key_exists('champion', $params)) {
//            $paramValues = explode(',', str_replace(' ', '', $params['champion']));
//            foreach ($paramValues as $pv) {
//                if (! is_numeric($pv)) {
//                    $champion = $this->getServiceManager()->get('Ololz\Service\Persist\Champion')->getMapper()->findOneByCode($pv);
//                    if ($champion instanceof Entity\Champion) {
//                        $query->andWhere('i.champion = :' . str_replace('-', '', $pv))
//                              ->setParameter(str_replace('-', '', $pv), $champion->getId());
//                    }
//                } else {
//                    $query->andWhere('i.champion = :champion' . $pv)
//                          ->setParameter('champion' . $pv, $pv);
//                }
//            }
//        }
//

        $this->setQuery($query);

        return parent::search();
    }
}