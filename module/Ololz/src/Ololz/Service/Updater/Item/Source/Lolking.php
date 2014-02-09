<?php
namespace Ololz\Service\Updater;

use Ololz\Entity;

/**
 * Item updater
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Item extends Updater
{
    public function update()
    {
        $itemService = $this->getServiceManager()->get('Ololz\Service\Persist\Item');
        $mappingService = $this->getServiceManager()->get('Ololz\Service\Persist\Mapping');

        $html = file_get_contents('http://www.lolking.net/items/');
        $doc = \phpQuery::newDocumentHTML($html);
        \phpQuery::selectDocument($doc);

        $lolKingSource = $this->getServiceManager()->get('Ololz\Mapper\Source')->findOneByCode(Entity\Source::CODE_LOLKING);

        $htmlItems = pq('.item-list a');
        $htmlItems = pq($htmlItems);

        foreach ($htmlItems as $htmlItem) {
            $htmlItem = pq($htmlItem);
            $itemTheirs = str_replace('/items/', '', $htmlItem->attr('href'));
            $itemName = $htmlItem['.info .name']->text();

            $item = new Entity\Item;
            $item->setName($itemName);

            if (! $itemService->exists($item)) {
                $this->getLogger()->info('Saving item ' . $item . '.');
                $item = $itemService->save($item, true);

                $mapping = new Entity\Mapping;
                $mapping->setSource($lolKingSource)
                        ->setType(Entity\Mapping::TYPE_ITEM)
                        ->setColumn(Entity\Mapping::COLUMN_ID)
                        ->setOurs($item->getId())
                        ->setTheirs($itemTheirs);
                $mappingService->save($mapping);
            } else {
                $this->getLogger()->info('Item ' . $item . ' already exists.');
            }
        }

        $itemService->getMapper()->flush();
    }
}
