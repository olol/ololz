<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * Champion entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="champion")
 */
class Champion extends Base
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
     * @ORM\ManyToOne(targetEntity="Position", fetch="LAZY")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * @JMS\Type("Ololz\Entity\Position")
     */
    protected $position;

    /**
     * @ORM\OneToMany(targetEntity="Invocation", cascade={"persist"}, fetch="LAZY", mappedBy="champion")
     * @JMS\Type("ArrayCollection<Ololz\Entity\Invocation>")
     */
    protected $invocations;

    /**
     * Construct entity Champion
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
     * @return \Ololz\Entity\Champion
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
     * @param string $code
     *
     * @return \Ololz\Entity\Champion
     */
    public function setCode($code)
    {
        $this->code = (string) $code;

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
     * @return \Ololz\Entity\Champion
     */
    public function setPosition(Position $position)
    {
        $this->position = $position;

        return $this;
    }
}