<?php
namespace Ololz\Service\Updater\Match;

use Ololz\Service\Updater\Updater;

/**
 * Match updater
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
abstract class Match extends Updater
{
    /**
     * @var array
     */
    protected $summoners;

    /**
     * @param array $summoners
     *
     * @return \Ololz\Service\Updater\Match
     */
    public function setSummoners(array $summoners)
    {
        $this->summoners = $summoners;

        return $this;
    }

    /**
     * @return \Ololz\Entity\Summoner
     */
    public function getSummoners()
    {
        if (is_null($this->summoners)) {
            $this->setSummoners($this->getService('Summoner')->getMapper()->findByActive(true));
        }

        return $this->summoners;
    }
}
