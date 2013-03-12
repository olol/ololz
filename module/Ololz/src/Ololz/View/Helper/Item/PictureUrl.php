<?php

namespace Ololz\View\Helper\Item;

use Ololz\Entity\Item;
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
    public function __invoke(Item $item, $type = self::TYPE_ICON, Source $source = null)
    {
        if (is_null($source)) {
            $source = $this->defaultSource;
        }

        if (is_null($source)) {
            throw new \InvalidArgumentException('Please set a default source to retrieve item\'s picture URL from the view helper');
        }

        switch ($source->getCode())
        {
            case Source::CODE_LOLKING:
                $lolKingId = $this->getMappingMapper()->findOneTheirs($source, Mapping::TYPE_ITEM, Mapping::COLUMN_ID, $item->getId());

                switch ($type)
                {
                    case self::TYPE_ICON:
                        $url = 'http://img.lolking.net/shared/riot/images/items/' . $lolKingId . '_32.png';
                        break;

                    case self::TYPE_SMALL:
                        $url = 'http://img.lolking.net/shared/riot/images/items/' . $lolKingId . '_64.png';
                        break;

                    default:
                        throw new \Exception('Can only retrieve item picture\'s urls for LolKing\'s icons for now.');
                        break;
                }
                break;

            default:
                throw new \Exception('Can only retrieve item picture\'s urls from LolKing for now.');
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
     * @return \Ololz\View\Helper\Item
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
     * @return \Ololz\View\Helper\Item
     */
    public function setMappingMapper(MappingMapper $mappingMapper)
    {
        $this->mappingMapper = $mappingMapper;

        return $this;
    }
}
