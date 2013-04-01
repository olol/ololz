<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Summoner entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="summoner")
 */
class Summoner extends Base
{
    /**
     * @ORM\Column(type="string", name="name", length=32, nullable=false)
     */
    protected $name;

    const REALM_BR      = 'br';
    const REALM_EUNE    = 'eune';
    const REALM_EUW     = 'euw';
    const REALM_KR      = 'kr';
    const REALM_NA      = 'na';

    /**
     * @ORM\Column(type="string", name="realm", length=10)
     */
    protected $realm;

    /**
     * @ORM\OneToMany(targetEntity="Invocation", cascade={"persist"}, fetch="LAZY", mappedBy="summoner")
     */
    protected $invocations;

    /**
     * @ORM\OneToMany(targetEntity="Mapping", cascade={"persist"}, fetch="LAZY", mappedBy="ours")
     */
    protected $mappings;

    /**
     * @ORM\Column(type="boolean", name="active")
     */
    protected $active;

    /**
     * Construct entity Summoner
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
        return (string) $this->getName();
    }

    /**
     * @param string    $name
     *
     * @return \Ololz\Entity\Summoner
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * @return string
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getMappings()
    {
//        if ($this->mappings->count()) {
            $criteria = Criteria::create()->where(Criteria::expr()->eq('type', Mapping::TYPE_SUMMONER));
            return $this->mappings->matching($criteria);
//        }

        return null;
    }

    /**
     * @param \Ololz\Entity\Source  $source
     * @param \Ololz\Entity\Source  $column
     *
     * @return \Ololz\Entity\Mapping
     */
    public function getMappingBySource($source, $column)
    {
//        if ($this->mappings->count()) {
            $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('type', Mapping::TYPE_SUMMONER))
                ->andWhere(Criteria::expr()->eq('source', $source))
                ->andWhere(Criteria::expr()->eq('column', $column));
            return $this->mappings->matching($criteria)->first();
//        }

        return null;
    }

    /**
     * @return array
     */
    public static function getRealms()
    {
        return array(
            self::REALM_BR,
            self::REALM_EUNE,
            self::REALM_EUW,
            self::REALM_KR,
            self::REALM_NA
        );
    }

    /**
     * @param string    $realm
     *
     * @return \Ololz\Entity\Summoner
     */
    public function setRealm($realm)
    {
        if (! in_array($realm, self::getRealms())) {
            throw new \InvalidArgumentException('Invalid realm. "' + $realm + '" given while only "' . implode('", "', self::getRealms() . '" are allowed.'));
        }
        $this->realm = (string) $realm;

        return $this;
    }

    /**
     * @return string
     *
     */
    public function getRealm()
    {
        return $this->realm;
    }

    /**
     * @param array $invocations
     * @param bool  $inverse
     *
     * @return \Ololz\Entity\Summoner
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
     * @return \Ololz\Entity\Summoner
     */
    public function addInvocation(Invocation $invocation, $inverse = true)
    {
        $this->invocations[] = $invocation;
        if ($inverse == true) {
            $invocation->setSummoner($this, false);
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
     * @return \Ololz\Entity\Summoner
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
     * @return \Ololz\Entity\Summoner
     */
    public function removeInvocation(Invocation $invocation, $inverse = true)
    {
        foreach ($this->invocations as $key => $currentInvocation) {

            if ($invocation === $currentInvocation) {
                unset($this->invocations[$key]);
                if ($inverse == true) {
                    $invocation->setSummoner(null, false);
                }
                break;
            }
        }

        return $this;
    }

    /**
     * @param bool $active
     *
     * @return \Ololz\Entity\Summoner
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }
}