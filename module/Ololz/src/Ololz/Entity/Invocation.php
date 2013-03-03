<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Invocation entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="invocation")
 */
class Invocation extends Base
{
    /**
     * @ORM\ManyToOne(targetEntity="Summoner", fetch="LAZY", cascade={"persist", "detach"}, inversedBy="invocations")
     * @ORM\JoinColumn(name="summoner_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\Summoner")
     */
    protected $summoner;

    /**
     * @ORM\ManyToOne(targetEntity="Champion", fetch="LAZY", cascade={"detach"})
     * @ORM\JoinColumn(name="champion_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\Champion")
     */
    protected $champion;

    /**
     * @ORM\ManyToOne(targetEntity="MatchTeam", fetch="LAZY", cascade={"persist", "detach"}, inversedBy="invocations")
     * @ORM\JoinColumn(name="match_team_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\MatchTeam")
     */
    protected $matchTeam;

    /**
     * @ORM\ManyToMany(targetEntity="Item", fetch="LAZY", cascade={"detach"})
     * @ORM\JoinTable(
     *      name="invocation_item",
     *      joinColumns={@ORM\JoinColumn(name="invocation_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")}
     * )
     * @JMS\Type("ArrayCollection<Application\Entity\Item>")
     */
    protected $items;

    /**
     * @ORM\ManyToMany(targetEntity="Spell", fetch="LAZY", cascade={"detach"})
     * @ORM\JoinTable(
     *      name="invocation_spell",
     *      joinColumns={@ORM\JoinColumn(name="invocation_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="spell_id", referencedColumnName="id")}
     * )
     * @JMS\Type("ArrayCollection<Application\Entity\Spell>")
     */
    protected $spells;

    /**
     * @ORM\ManyToOne(targetEntity="Position", fetch="LAZY", cascade={"detach"})
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\Position")
     */
    protected $position;

    /**
     * @ORM\Column(type="integer", name="kills", length=5)
     * @JMS\Type("integer")
     */
    protected $kills;

    /**
     * @ORM\Column(type="integer", name="deaths", length=5)
     * @JMS\Type("integer")
     */
    protected $deaths;

    /**
     * @ORM\Column(type="integer", name="assists", length=5)
     * @JMS\Type("integer")
     */
    protected $assists;

    /**
     * @ORM\Column(type="float", name="gold")
     * @JMS\Type("float")
     */
    protected $gold;

    /**
     * @ORM\Column(type="integer", name="minions", length=5)
     * @JMS\Type("integer")
     */
    protected $minions;

    /**
     * @ORM\Column(type="float", name="damage_dealt")
     * @JMS\Type("float")
     */
    protected $damageDealt;

    /**
     * @ORM\Column(type="float", name="damage_received")
     * @JMS\Type("float")
     */
    protected $damageReceived;

    /**
     * @ORM\Column(type="float", name="healing_done")
     * @JMS\Type("float")
     */
    protected $healingDone;

    /**
     * @ORM\Column(type="integer", name="largest_multi_kill", length=3)
     * @JMS\Type("integer")
     */
    protected $largestMultiKill;

    /**
     * @ORM\Column(type="integer", name="time_spent_dead", length=5)
     * @JMS\Type("integer")
     */
    protected $timeSpentDead;

    /**
     * @ORM\Column(type="integer", name="turrets_destroyed", length=3)
     * @JMS\Type("integer")
     */
    protected $turretsDestroyed;

    /**
     * Construct entity Invocation
     */
    public function __construct()
    {
        $this->items    = array();
        $this->spells   = array();

        parent::__construct();
    }

    /**
     * @return string
     */
    public function getDisplayedLabel()
    {
        return (string) $this->getKills() . '/' . $this->getDeaths() . '/' . $this->getAssists();
    }

    /**
     * @return \Ololz\Entity\Summoner
     */
    public function getSummoner()
    {
        return $this->summoner;
    }

    /**
     * @param string    $summoner
     * @param bool      $inverse
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setSummoner(Summoner $summoner = null, $inverse = true)
    {
        if ($inverse == true && $this->summoner) {
            $this->summoner->removeInvocation($this, false);
        }

        $this->summoner = $summoner;

        if ($inverse == true && !is_null($summoner)) {
            $summoner->addInvocation($this, false);
        }

        return $this;
    }

    /**
     * @return \Ololz\Entity\Champion
     */
    public function getChampion()
    {
        return $this->champion;
    }

    /**
     * @param string    $champion
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setChampion(Champion $champion)
    {
        $this->champion = $champion;

        return $this;
    }

    /**
     * @return \Ololz\Entity\MatchTeam
     */
    public function getMatchTeam()
    {
        return $this->matchTeam;
    }

    /**
     * @param string    $matchTeam
     * @param bool      $inverse
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setMatchTeam(MatchTeam $matchTeam = null, $inverse = true)
    {
        if ($inverse == true && $this->matchTeam) {
            $this->matchTeam->removeInvocation($this, false);
        }

        $this->matchTeam = $matchTeam;

        if ($inverse == true && !is_null($matchTeam)) {
            $matchTeam->addInvocation($this, false);
        }

        return $this;
    }

    /**
     * @param array $items
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setItems($items = null)
    {
        $this->removeItems();
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @param \Ololz\Entity\Item $item
     *
     * @return \Ololz\Entity\Invocation
     */
    public function addItem(Item $item)
    {
        if (count($this->getItems()) >= 6) {
            throw new \Exception('You can not add more than 6 items for a invocation.');
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param \Ololz\Entity\Item $item
     *
     * @return bool
     */
    public function hasItem(Item $item)
    {
        foreach ($this->items as $currentItem) {

            if ($currentItem === $item) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \Ololz\Entity\Invocation
     */
    public function removeItems()
    {
        foreach ($this->items as $item) {
            $this->removeItem($item);
        }
        $this->items = array();

        return $this;
    }

    /**
     * @param \Ololz\Entity\Item $item
     *
     * @return \Ololz\Entity\Invocation
     */
    public function removeItem(Item $item)
    {
        foreach ($this->items as $key => $currentItem) {

            if ($item === $currentItem) {
                unset($this->items[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * @param array $spells
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setSpells($spells = null)
    {
        $this->removeSpells();
        foreach ($spells as $spell) {
            $this->addSpell($spell);
        }

        return $this;
    }

    /**
     * @param \Ololz\Entity\Spell $spell
     *
     * @return \Ololz\Entity\Invocation
     */
    public function addSpell(Spell $spell)
    {
        if (count($this->getSpells()) >= 2) {
            throw new \Exception('You can not add more than 2 spells for a invocation.');
        }

        $this->spells[] = $spell;

        return $this;
    }

    /**
     * @return array
     */
    public function getSpells()
    {
        return $this->spells;
    }

    /**
     * @param \Ololz\Entity\Spell $spell
     *
     * @return bool
     */
    public function hasSpell(Spell $spell)
    {
        foreach ($this->spells as $currentSpell) {

            if ($currentSpell === $spell) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \Ololz\Entity\Invocation
     */
    public function removeSpells()
    {
        foreach ($this->spells as $spell) {
            $this->removeSpell($spell);
        }
        $this->spells = array();

        return $this;
    }

    /**
     * @param \Ololz\Entity\Spell $spell
     *
     * @return \Ololz\Entity\Invocation
     */
    public function removeSpell(Spell $spell)
    {
        foreach ($this->spells as $key => $currentSpell) {

            if ($spell === $currentSpell) {
                unset($this->spells[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * @return \Ololz\Entity\Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string    $position
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setPosition(Position $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return int
     */
    public function getKills()
    {
        return $this->kills;
    }

    /**
     * @param int   $kills
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setKills($kills)
    {
        $this->kills = (int) $kills;

        return $this;
    }

    /**
     * @return int
     */
    public function getDeaths()
    {
        return $this->deaths;
    }

    /**
     * @param int   $deaths
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setDeaths($deaths)
    {
        $this->deaths = (int) $deaths;

        return $this;
    }

    /**
     * @return int
     */
    public function getAssists()
    {
        return $this->assists;
    }

    /**
     * @param int   $assists
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setAssists($assists)
    {
        $this->assists = (int) $assists;

        return $this;
    }

    /**
     * @return float
     */
    public function getGold()
    {
        return (float) $this->gold;
    }

    /**
     * @param float $gold
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setGold($gold)
    {
        $this->gold = (float) $gold;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinions()
    {
        return $this->minions;
    }

    /**
     * @param int   $minions
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setMinions($minions)
    {
        $this->minions = (int) $minions;

        return $this;
    }

    /**
     * @return float
     */
    public function getDamageDealt()
    {
        return (float) $this->damageDealt;
    }

    /**
     * @param float $damageDealt
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setDamageDealt($damageDealt)
    {
        $this->damageDealt = (float) $damageDealt;

        return $this;
    }

    /**
     * @return float
     */
    public function getDamageReceived()
    {
        return (float) $this->damageReceived;
    }

    /**
     * @param float $damageReceived
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setDamageReceived($damageReceived)
    {
        $this->damageReceived = (float) $damageReceived;

        return $this;
    }

    /**
     * @return float
     */
    public function getHealingDone()
    {
        return (float) $this->healingDone;
    }

    /**
     * @param float $healingDone
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setHealingDone($healingDone)
    {
        $this->healingDone = (float) $healingDone;

        return $this;
    }

    /**
     * @return int
     */
    public function getLargestMultiKill()
    {
        return $this->largestMultiKill;
    }

    /**
     * @param int   $largestMultiKill
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setLargestMultiKill($largestMultiKill)
    {
        $this->largestMultiKill = (int) $largestMultiKill;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeSpentDead()
    {
        return $this->timeSpentDead;
    }

    /**
     * @param int   $timeSpentDead
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setTimeSpentDead($timeSpentDead)
    {
        $this->timeSpentDead = (int) $timeSpentDead;

        return $this;
    }

    /**
     * @return int
     */
    public function getTurretsDestroyed()
    {
        return $this->turretsDestroyed;
    }

    /**
     * @param int   $turretsDestroyed
     *
     * @return \Ololz\Entity\Invocation
     */
    public function setTurretsDestroyed($turretsDestroyed)
    {
        $this->turretsDestroyed = (int) $turretsDestroyed;

        return $this;
    }
}