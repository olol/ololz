<?php

namespace Ololz\View\Helper\Champion;

use Ololz\Entity\Champion;
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
    public function __invoke(Champion $champion, $type = self::TYPE_ICON, Source $source = null)
    {
        if (is_null($source)) {
            $source = $this->defaultSource;
        }

        if (is_null($source)) {
            throw new \InvalidArgumentException('Please set a default source to retrieve champion\'s picture URL from the view helper');
        }

        switch ($source->getCode())
        {
            case Source::CODE_LOLKING:
                $lolKingId = $this->getMappingMapper()->findOneTheirs($source, Mapping::TYPE_CHAMPION, Mapping::COLUMN_ID, $champion->getId());

                switch ($type)
                {
                    case self::TYPE_ICON:
                        $url = 'http://img.lolking.net/shared/riot/images/champions/' . $lolKingId . '_64.png';
                        break;

                    case self::TYPE_SMALL:
                        $url = 'http://img.lolking.net/shared/riot/images/champions/' . $lolKingId . '_92.png';
                        break;

                    default:
                        throw new \Exception('Can only retrieve champion picture\'s urls for LolKing\'s icons for now.');
                        break;
                }
                break;

            default:
                throw new \Exception('Can only retrieve champion picture\'s urls from LolKing for now.');
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
     * @return \Ololz\View\Helper\Champion
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
     * @return \Ololz\View\Helper\Champion
     */
    public function setMappingMapper(MappingMapper $mappingMapper)
    {
        $this->mappingMapper = $mappingMapper;

        return $this;
    }
}
