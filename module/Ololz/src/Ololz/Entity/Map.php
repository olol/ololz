<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * Map entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="map")
 */
class Map extends Base
{
    /**
     * @ORM\Column(type="string", name="name", length=32, nullable=false)
     * @JMS\Type("string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="code", length=32, nullable=false, unique=true)
     * @JMS\Type("string")
     * @Gedmo\Slug(fields={"name"}, unique=true)
     */
    protected $code;

    /**
     * @ORM\OneToMany(targetEntity="MatchType", fetch="LAZY", mappedBy="map")
     * @JMS\Type("ArrayCollection<Ololz\Entity\MatchType>")
     */
    protected $matchTypes;

    /**
     * Construct entity Map
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
        return (string) $this->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string    $name
     *
     * @return \Ololz\Entity\Map
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param array $matchTypes
     * @param bool  $inverse
     *
     * @return \Ololz\Entity\Map
     */
    public function setMatchTypes($matchTypes, $inverse = true)
    {
        $this->removeMatchTypes($inverse);
        foreach ($matchTypes as $matchType) {
            $this->addMatchType($matchType, $inverse);
        }

        return $this;
    }

    /**
     * @param \Ololz\Entity\MatchType   $matchType
     * @param bool                      $inverse
     *
     * @return \Ololz\Entity\Map
     */
    public function addMatchType(MatchType $matchType, $inverse = true)
    {
        $this->matchTypes[] = $matchType;
        if ($inverse == true) {
            $matchType->setMap($this, false);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getMatchTypes()
    {
        return $this->matchTypes;
    }

    /**
     * @param \Ololz\Entity\MatchType  $matchType
     *
     * @return bool
     */
    public function hasMatchType(MatchType $matchType)
    {
        foreach ($this->matchTypes as $currentMatchType) {

            if ($currentMatchType === $matchType) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param bool  $inverse
     *
     * @return \Ololz\Entity\Map
     */
    public function removeMatchTypes($inverse = true)
    {
        foreach ($this->matchTypes as $matchType) {
            $this->removeMatchType($matchType, $inverse);
        }
        $this->matchTypes = array();

        return $this;
    }

    /**
     * @param \Ololz\Entity\MatchType   $matchType
     * @param bool                      $inverse
     *
     * @return \Ololz\Entity\Map
     */
    public function removeMatchType(MatchType $matchType, $inverse = true)
    {
        foreach ($this->matchTypes as $key => $currentMatchType) {

            if ($matchType === $currentMatchType) {
                unset($this->matchTypes[$key]);
                if ($inverse == true) {
                    $matchType->setMap(null, false);
                }
                break;
            }
        }

        return $this;
    }
}