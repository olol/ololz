<?php
namespace Ololz\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Source entity class
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="source")
 */
class Source extends Base
{
    /**
     * @ORM\Column(type="string", name="name", length=32, nullable=false)
     */
    protected $name;

    const CODE_LOLKING  = 'lolking';
    const CODE_MOBAFIRE = 'mobafire';

    /**
     * @ORM\Column(type="string", name="code", length=32, nullable=false, unique=true)
     * @Gedmo\Slug(fields={"name"}, unique=true)
     */
    protected $code;

    /**
     * Construct entity Source
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
     * @return \Ololz\Entity\Source
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
     * @param type $code
     *
     * @return \Ololz\Entity\Source
     */
    public function setCode($code)
    {
        $this->code = (string) $code;

        return $this;
    }
}