<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * MatchTeam entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="match_team")
 */
class MatchTeam extends Base
{
    /**
     * @ORM\ManyToOne(targetEntity="Match", fetch="LAZY", cascade={"persist", "detach"}, inversedBy="matchTeams")
     * @ORM\JoinColumn(name="match_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\Match")
     */
    protected $match;

    /**
     * @ORM\OneToMany(targetEntity="Invocation", fetch="LAZY", cascade={"persist", "detach"}, mappedBy="matchTeam")
     * @JMS\Type("ArrayCollection<Ololz\Entity\Invocation>")
     */
    protected $invocations;

    /**
     * Construct entity MatchTeam
     */
    public function __construct()
    {
        $this->invocations = array();

        parent::__construct();
    }

    /**
     * @return string
     */
    public function getDisplayedLabel()
    {
        $label = array();
        foreach ($this->getInvocations() as $invocation) {
            $label[] = (string) $invocation->getSummoner() . ' (' . (string) $invocation->getChampion() . ')';
        }

        return implode(', ', $label);
    }

    /**
     * @return \Ololz\Entity\Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @param string    $match
     * @param bool      $inverse
     *
     * @return \Ololz\Entity\MatchTeam
     */
    public function setMatch(Match $match = null, $inverse = true)
    {
        if ($inverse == true && $this->match) {
            $this->match->removeMatchTeam($this, false);
        }

        $this->match = $match;

        if ($inverse == true && !is_null($match)) {
            $match->addMatchTeam($this, false);
        }

        return $this;
    }

    /**
     * @param array $invocations
     * @param bool  $inverse
     *
     * @return \Ololz\Entity\MatchTeam
     */
    public function setInvocations($invocations, $inverse = true)
    {
        $this->removeInvocations($inverse);
        foreach ($invocations as $invocation) {
            $this->addInvocation($invocation, $inverse);
        }

        return $this;
    }

    /**
     * @param \Ololz\Entity\Invocation  $invocation
     * @param bool                      $inverse
     *
     * @return \Ololz\Entity\MatchTeam
     */
    public function addInvocation(Invocation $invocation, $inverse = true)
    {
        if (count($this->getInvocations()) >= 5) {
            throw new \Exception('You can not add more than 5 invocations for a team.');
        }

        $this->invocations[] = $invocation;
        if ($inverse == true) {
            $invocation->setMatchTeam($this, false);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getInvocations()
    {
        return $this->invocations;
    }

    /**
     * @param \Ololz\Entity\Invocation  $invocation
     *
     * @return bool
     */
    public function hasInvocation(Invocation $invocation)
    {
        foreach ($this->invocations as $currentInvocation) {

            if ($currentInvocation === $invocation) {
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
    public function removeInvocations($inverse = true)
    {
        foreach ($this->invocations as $invocation) {
            $this->removeInvocation($invocation, $inverse);
        }
        $this->invocations = array();

        return $this;
    }

    /**
     * @param \Ololz\Entity\Invocation  $invocation
     * @param bool                      $inverse
     *
     * @return \Ololz\Entity\MatchTeam
     */
    public function removeInvocation(Invocation $invocation, $inverse = true)
    {
        foreach ($this->invocations as $key => $currentInvocation) {

            if ($invocation === $currentInvocation) {
                unset($this->invocations[$key]);
                if ($inverse == true) {
                    $invocation->setMatchTeam(null, false);
                }
                break;
            }
        }

        return $this;
    }

    /**
     * @return \Ololz\Entity\MatchTeam
     */
    public function getOpponent()
    {
        return $this->getMatch()->getOpponentOf($this);
    }

    /**
     * @return bool
     */
    public function hasWon()
    {
        return $this->getMatch()->getWinner() == $this;
    }

    /**
     * @return bool
     */
    public function hasLost()
    {
        return ! $this->hasWon();
    }
}