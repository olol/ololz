<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Base entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/** @ORM\MappedSuperclass */
abstract class Base
{
    /**
     * @ORM\Id @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * Constructor base entity
     *
     * @access public
     *
     * @return void
     */
    public function __construct() {}

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getDisplayedLabel();
    }

    /**
     * @return string
     */
    public function getDisplayedLabel()
    {
        return (string) $this->getId();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Base
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }
}
