<?php
namespace Ololz\Service\Updater\Summoner\Source;

use Ololz\Entity;
use Ololz\Service;
use Ololz\Service\Updater\Summoner\Summoner;

/**
 * Summoner updater via Lolking website
 *
 * @since   0.2
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Lolking extends Summoner
{
    /**
     * @var \Ololz\Entity\Summoner
     */
    protected $summoner;

    /**
     * @var \Ololz\Service\Updater\Match
     */
    protected $matchUpdater;

    public function __construct()
    {
        set_time_limit(0);
    }

    /**
     * @param \Ololz\Entity\Summoner $summoner
     *
     * @return \Ololz\Service\Updater\Summoner
     */
    public function setSummoner(Entity\Summoner $summoner)
    {
        $this->summoner = $summoner;

        return $this;
    }

    /**
     * @return \Ololz\Entity\Summoner
     */
    public function getSummoner()
    {
        return $this->summoner;
    }

    /**
     * @param \Ololz\Service\Updater\Match $matchUpdater
     *
     * @return \Ololz\Service\Updater\Summoner
     */
    public function setMatchUpdater(Service\Updater\Match\Match $matchUpdater)
    {
        $this->matchUpdater = $matchUpdater;

        return $this;
    }

    /**
     * @return \Ololz\Service\Updater\Match
     */
    public function getMatchUpdater()
    {
        if (is_null($this->matchUpdater)) {
            $this->setMatchUpdater($this->getUpdater('Match'));
        }

        return $this->matchUpdater;
    }

    /**
     * Only updates summoner's match for now.
     */
    public function update()
    {
        if ($this->getSummoner()) {
            $matchUpdater = $this->getMatchUpdater();
            $matchUpdater->setSummoners(array($this->getSummoner()));
            $matchUpdater->update();
        }
    }
}
