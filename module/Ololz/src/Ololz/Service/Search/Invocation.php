<?php
namespace Ololz\Service\Search;

use Ololz\Entity;

/**
 * Invocation search service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Invocation extends Base
{
    /**
     * @var \Ololz\Entity\Summoner
     */
    protected $summoner;

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
     * @param \Ololz\Service\Search\Entity\Summoner $summoner
     *
     * @return \Ololz\Service\Search\Invocation
     */
    public function setSummoner(Entity\Summoner $summoner)
    {
        $this->summoner = $summoner;

        return $this;
    }

    /**
     * @return \Ololz\Service\Search\Entity\Summoner
     */
    public function getSummoner()
    {
        return $this->summoner;
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
        $this->setMappedFields(array('champion' => 'i.champion', 'position' => 'i.position', 'map' => 'm.map', 'match_type' => 'm.matchType'));
    }

    /**
     * {@inheritDoc}
     */
    public function search()
    {
        $this->setQuery($this->getService()->getMapper()->findBySummonerAndMatchDateQuery(
            $this->getSummoner(),
            $this->getDateStart(),
            $this->getDateEnd(),
            $this->getCriteria(),
            $this->getOrderBy(),
            $this->getLimit(),
            $this->getOffset()
        ) );

        return parent::search();
    }
}