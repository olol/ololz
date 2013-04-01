<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MatchType entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="match_type")
 */
class MatchType extends Base
{
    /**
     * @ORM\Column(type="string", name="name", length=32, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="code", length=32, nullable=false, unique=true)
     * @Gedmo\Slug(fields={"name"}, unique=true)
     */
    protected $code;

    /**
     * @ORM\ManyToOne(targetEntity="Map", fetch="LAZY")
     * @ORM\JoinColumn(name="map_id", referencedColumnName="id")
     */
    protected $map;

    /**
     * Construct entity MatchType
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
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string    $name
     *
     * @return \Ololz\Entity\MatchType
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
     * @return \Ololz\Entity\Map
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @param string    $map
     * @param bool      $inverse
     *
     * @return \Ololz\Entity\MatchType
     */
    public function setMap(Map $map = null, $inverse = true)
    {
        if ($inverse == true && $this->map) {
            $this->map->removeMatchType($this, false);
        }

        $this->map = $map;

        if ($inverse == true && !is_null($map)) {
            $map->addMatchType($this, false);
        }

        return $this;
    }
}