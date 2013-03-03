<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Match entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="`match`")
 */
class Match extends Base
{
    /**
     * @ORM\ManyToOne(targetEntity="Map", fetch="LAZY", cascade={"detach"})
     * @ORM\JoinColumn(name="map_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\Map")
     */
    protected $map;

    /**
     * @ORM\OneToOne(targetEntity="MatchTeam", fetch="LAZY", cascade={"persist", "detach"})
     * @ORM\JoinColumn(name="winner_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\MatchTeam")
     */
    protected $winner;

    /**
     * @ORM\OneToOne(targetEntity="MatchTeam", fetch="LAZY", cascade={"persist", "detach"})
     * @ORM\JoinColumn(name="loser_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\MatchTeam")
     */
    protected $loser;

    /**
     * @ORM\OneToMany(targetEntity="MatchTeam", cascade={"all"}, fetch="LAZY", mappedBy="match")
     * @JMS\Type("ArrayCollection<Ololz\Entity\MatchTeam>")
     */
    protected $matchTeams;

    /**
     * @ORM\ManyToOne(targetEntity="MatchType", fetch="LAZY", cascade={"detach"})
     * @ORM\JoinColumn(name="match_type_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\MatchType")
     */
    protected $matchType;

    /**
     * @ORM\Column(type="string", name="hash", length=32, nullable=false, unique=true)
     * @JMS\Type("string")
     */
    protected $hash;

    /**
     * @ORM\Column(type="datetime", name="date", length=32)
     * @JMS\Type("DateTime")
     */
    protected $date;

    /**
     * @ORM\Column(type="integer", name="length", length=16)
     * @JMS\Type("integer")
     */
    protected $length;

    /**
     * Construct entity Match
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getDisplayedLabel()
    {
        $label = array();
        foreach ($this->getMatchTeams() as $matchTeam) {
            $label[] = (string) $matchTeam;
        }

        return implode(' VS ', $label);
    }

    /**
     * @return \Ololz\Entity\Map
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @param string    $map
     *
     * @return \Ololz\Entity\Match
     */
    public function setMap(Map $map = null)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @return \Ololz\Entity\MatchTeam
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param string    $winner
     *
     * @return \Ololz\Entity\Match
     */
    public function setWinner(MatchTeam $winner = null)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * @return \Ololz\Entity\MatchTeam
     */
    public function getLoser()
    {
        return $this->loser;
    }

    /**
     * @param string    $loser
     *
     * @return \Ololz\Entity\Match
     */
    public function setLoser(MatchTeam $loser = null)
    {
        $this->loser = $loser;

        return $this;
    }

    /**
     * @param array $matchTeams
     * @param bool  $inverse
     *
     * @return \Ololz\Entity\MatchTeam
     */
    public function setMatchTeams($matchTeams, $inverse = true)
    {
        $this->removeMatchTeams($inverse);
        foreach ($matchTeams as $matchTeam) {
            $this->addMatchTeam($matchTeam, $inverse);
        }

        return $this;
    }

    /**
     * @param \Ololz\Entity\MatchTeam   $matchTeam
     * @param bool                      $inverse
     *
     * @return \Ololz\Entity\MatchTeam
     */
    public function addMatchTeam(MatchTeam $matchTeam, $inverse = true)
    {
        if (count($this->getMatchTeams()) >= 2) {
            throw new \Exception('You can not add more than 2 teams for a match.');
        }

        $this->matchTeams[] = $matchTeam;
        if ($inverse == true) {
            $matchTeam->setMatch($this, false);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getMatchTeams()
    {
        return $this->matchTeams;
    }

    /**
     * @param \Ololz\Entity\MatchTeam   $matchTeam
     *
     * @return bool
     */
    public function hasMatchTeam(MatchTeam $matchTeam)
    {
        foreach ($this->matchTeams as $currentMatchTeam) {

            if ($currentMatchTeam === $matchTeam) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param bool  $inverse
     *
     * @return \Ololz\Entity\MatchTeam
     */
    public function removeMatchTeams($inverse = true)
    {
        foreach ($this->matchTeams as $matchTeam) {
            $this->removeMatchTeam($matchTeam, $inverse);
        }
        $this->matchTeams = array();

        return $this;
    }

    /**
     * @param \Ololz\Entity\MatchTeam   $matchTeam
     * @param bool                      $inverse
     *
     * @return \Ololz\Entity\MatchTeam
     */
    public function removeMatchTeam(MatchTeam $matchTeam, $inverse = true)
    {
        foreach ($this->matchTeams as $key => $currentMatchTeam) {

            if ($matchTeam === $currentMatchTeam) {
                unset($this->matchTeams[$key]);
                if ($inverse == true) {
                    $matchTeam->setMatch(null, false);
                }
                break;
            }
        }

        return $this;
    }

    /**
     * @param \Ololz\Entity\MatchTeam   $matchTeam
     *
     * @return \Ololz\Entity\MatchTeam
     */
    public function getOpponentOf(MatchTeam $matchTeam)
    {
        foreach ($this->getMatchTeams() as $currentMatchTeam) {
            if ($matchTeam != $currentMatchTeam) {
                return $currentMatchTeam;
            }
        }

        return null;
    }

    /**
     * @return \Ololz\Entity\MatchType
     */
    public function getMatchType()
    {
        return $this->matchType;
    }

    /**
     * @param string    $matchType
     *
     * @return \Ololz\Entity\Match
     */
    public function setMatchType(MatchType $matchType = null)
    {
        $this->matchType = $matchType;

        return $this;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string    $hash
     *
     * @return \Ololz\Entity\Match
     */
    public function setHash($hash)
    {
        $this->hash = (string) $hash;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return \Ololz\Entity\Match
     */
    public function setDate(\DateTime $date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int   $length
     *
     * @return \Ololz\Entity\Match
     */
    public function setLength($length)
    {
        $this->length = (int) $length;

        return $this;
    }
}