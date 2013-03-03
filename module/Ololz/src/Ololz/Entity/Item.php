<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * Item entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="item")
 */
class Item extends Base
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
     * Construct entity Item
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
     * @return \Ololz\Entity\Item
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
}