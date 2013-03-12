<?php

namespace Ololz\View\Helper\Spell;

use Ololz\Entity\Spell;
use Ololz\Entity\Source;
use Ololz\Entity\Mapping;
use Ololz\Mapper\Mapping as MappingMapper;

use Zend\View\Helper\AbstractHelper;

class PictureUrl extends AbstractHelper
{
    const TYPE_ICON     = 'icon';
    const TYPE_SMALL    = 'small';

    /**
     * @var \Ololz\Entity\Source
     */
    protected $defaultSource;

    /**
     * @var \Ololz\Mapper\Mapping
     */
    protected $mappingMapper;

    /**
     * @param  \Ololz\Entity\Spell  $spell
     * @param  string               $type
     * @param  \Ololz\Entity\Source $source
     *
     * @return string
     */
    public function __invoke(Spell $spell, $type = self::TYPE_ICON, Source $source = null)
    {
        if (is_null($source)) {
            $source = $this->defaultSource;
        }

        if (is_null($source)) {
            throw new \InvalidArgumentException('Please set a default source to retrieve spell\'s picture URL from the view helper');
        }

        switch ($source->getCode())
        {
            case Source::CODE_LOLKING:
                $lolKingId = $this->getMappingMapper()->findOneTheirs($source, Mapping::TYPE_SPELL, Mapping::COLUMN_ID, $spell->getId());

                switch ($type)
                {
                    case self::TYPE_ICON:
                        $url = 'http://img.lolking.net/images/spells/' . $lolKingId . '.png';
                        break;

                    default:
                        throw new \Exception('Can only retrieve spell picture\'s urls for LolKing\'s icons for now.');
                        break;
                }
                break;

            default:
                throw new \Exception('Can only retrieve spell picture\'s urls from LolKing for now.');
                break;
        }

        return $url;
    }

    /**
     * @return \Ololz\Entity\Source
     */
    protected function getDefaultSource()
    {
        return $this->defaultSource;
    }

    /**
     * @param  \Ololz\Entity\Source $defaultSource
     *
     * @return \Ololz\View\Helper\Spell
     */
    public function setDefaultSource(Source $defaultSource)
    {
        $this->defaultSource = $defaultSource;

        return $this;
    }

    /**
     * @return \Ololz\Mapper\Mapping
     */
    protected function getMappingMapper()
    {
        return $this->mappingMapper;
    }

    /**
     * @param  \Ololz\Entity\Source $mappingMapper
     *
     * @return \Ololz\View\Helper\Spell
     */
    public function setMappingMapper(MappingMapper $mappingMapper)
    {
        $this->mappingMapper = $mappingMapper;

        return $this;
    }
}
