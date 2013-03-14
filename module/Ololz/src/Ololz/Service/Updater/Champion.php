<?php
namespace Ololz\Service\Updater;

use Ololz\Entity;

/**
 * Champion updater
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Champion extends Updater
{
    private function positionMapping($lolKingSource, $mappingService)
    {
        $mappings = $mappingService->getMapper()->findBySourceAndTypeAndColumn($lolKingSource, Entity\Mapping::TYPE_POSITION, Entity\Mapping::COLUMN_ID);

        $return = array();
        foreach ($mappings as $mapping) {
            $return[$mapping->getTheirs()] = $mapping->getOurs();
        }

        return $return;
    }

    public function update()
    {
        $mappingService  = $this->getServiceManager()->get('Ololz\Service\Persist\Mapping');
        $championService = $this->getServiceManager()->get('Ololz\Service\Persist\Champion');
        $positionService = $this->getServiceManager()->get('Ololz\Service\Persist\Position');

        $html = file_get_contents('http://www.lolking.net/champions/');
        $doc = \phpQuery::newDocumentHTML($html);
        \phpQuery::selectDocument($doc);

        $lolKingSource = $this->getServiceManager()->get('Ololz\Service\Persist\Source')->getMapper()->findOneByCode(Entity\Source::CODE_LOLKING);

        $htmlChampions = pq('.champion-list tr');
        $htmlChampions = pq($htmlChampions);
        $positionMapping = $this->positionMapping($lolKingSource, $mappingService);

        foreach ($htmlChampions as $cptChampion => $htmlChampion) {
            if ($cptChampion == 0) {
                continue;
            }
            $htmlChampion = pq($htmlChampion);
            $htmlChampionName = pq($htmlChampion['> td:eq(0) > div:eq(1) a']);
            $championName = $htmlChampionName->text();
            $championTheirsCode = str_replace('/champions/', '', $htmlChampionName->attr('href'));
            $htmlChampionContainer = pq($htmlChampionName->parent()->parent());
            $championTheirsId = str_replace(array('background:url(//img.lolking.net/shared/riot/images/champions/', '_32.png)'), '', $htmlChampionContainer['.champion-list-icon']->attr('style'));
            $championPosition = $htmlChampion['> td:eq(6)']->text();
            $championPositionId = @$positionMapping[$championPosition];
            if (! $championPositionId) {
                continue;
            }

            $position = $positionService->getMapper()->find($championPositionId);
            if (! $position) {
                continue;
            }

            $champion = new Entity\Champion;
            $champion->setName($championName)
                     ->setPosition($position);

            if (! $championService->exists($champion)) {
                $this->getLogger()->info('Saving champion ' . $champion . '.');
                $champion = $championService->save($champion, true);

                $mappingId = new Entity\Mapping;
                $mappingId->setSource($lolKingSource)
                          ->setType(Entity\Mapping::TYPE_CHAMPION)
                          ->setColumn(Entity\Mapping::COLUMN_ID)
                          ->setOurs($champion->getId())
                          ->setTheirs($championTheirsId);
                $mappingService->save($mappingId);

                $mappingCode = new Entity\Mapping;
                $mappingCode->setSource($lolKingSource)
                            ->setType(Entity\Mapping::TYPE_CHAMPION)
                            ->setColumn(Entity\Mapping::COLUMN_CODE)
                            ->setOurs($champion->getId())
                            ->setTheirs($championTheirsCode);
                $mappingService->save($mappingCode);
            } else {
                $this->getLogger()->info('Champion ' . $champion . ' already exists.');
            }
        }

        $championService->getMapper()->flush();
    }
}
