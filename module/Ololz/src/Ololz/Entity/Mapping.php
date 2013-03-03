<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Mapping entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="mapping")
 */
class Mapping extends Base
{
    /**
     * @ORM\ManyToOne(targetEntity="Source", fetch="LAZY")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\Source")
     */
    protected $source;

    const TYPE_CHAMPION     = 'champion';
    const TYPE_ITEM         = 'item';
    const TYPE_MAP          = 'map';
    const TYPE_MATCH_TYPE   = 'match_type';
    const TYPE_POSITION     = 'position';
    const TYPE_SPELL        = 'spell';
    const TYPE_SUMMONER     = 'summoner';

    /**
     * @ORM\Column(type="string", name="type", length=16, nullable=false)
     * @JMS\Type("string")
     */
    protected $type;

    /**
     * @ORM\Column(type="integer", name="ours", length=10, nullable=false)
     * @JMS\Type("integer")
     */
    protected $ours;

    /**
     * @ORM\Column(type="string", name="theirs", length=64, nullable=false)
     * @JMS\Type("string")
     */
    protected $theirs;

    /**
     * Construct entity Mapping
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
     * @return \Ololz\Entity\Source
     *
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string    $source
     *
     * @return \Ololz\Entity\Mapping
     */
    public function setSource(Source $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return array(
            self::TYPE_CHAMPION,
            self::TYPE_ITEM,
            self::TYPE_MAP,
            self::TYPE_MATCH_TYPE,
            self::TYPE_POSITION,
            self::TYPE_SPELL,
            self::TYPE_SUMMONER,
        );
    }

    /**
     * @param string    $type
     *
     * @return \Ololz\Entity\Mapping
     */
    public function setType($type)
    {
        if (! in_array($type, self::getTypes())) {
            throw new \InvalidArgumentException('Invalid type. "' + $type + '" given while only "' . implode('", "', self::getTypes() . '" are allowed.'));
        }
        $this->type = (string) $type;

        return $this;
    }

    /**
     * @return string
     *
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getOurs()
    {
        return $this->ours;
    }

    /**
     * @param string $ours
     *
     * @return \Ololz\Entity\Mapping
     */
    public function setOurs($ours)
    {
        $this->ours = (int) $ours;

        return $this;
    }

    /**
     * @return string
     */
    public function getTheirs()
    {
        return $this->theirs;
    }

    /**
     * @param string $theirs
     *
     * @return \Ololz\Entity\Mapping
     */
    public function setTheirs($theirs)
    {
        $this->theirs = (string) $theirs;

        return $this;
    }
}