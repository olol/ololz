<?php
namespace Ololz\Service\Updater;

use Ololz\Entity;

/**
 * Match updater
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Match extends Updater
{
    public function update()
    {
                $em = $this->getServiceManager()->get('doctrine.entitymanager.orm_default');



        /* @var $championService \Ololz\Service\Persist\Champion */
        $championService    = $this->getServiceManager()->get('Ololz\Service\Persist\Champion');
        /* @var $matchService \Ololz\Service\Persist\Match */
        $matchService       = $this->getServiceManager()->get('Ololz\Service\Persist\Match');
        /* @var $matchTeamService \Ololz\Service\Persist\MatchTeam */
        $matchTeamService   = $this->getServiceManager()->get('Ololz\Service\Persist\MatchTeam');
        /* @var $matchTypeService \Ololz\Service\Persist\MatchType */
        $matchTypeService   = $this->getServiceManager()->get('Ololz\Service\Persist\MatchType');
        /* @var $summonerService \Ololz\Service\Persist\Summoner */
        $summonerService    = $this->getServiceManager()->get('Ololz\Service\Persist\Summoner');
        /* @var $mappingService \Ololz\Service\Persist\Mapping */
        $mappingService     = $this->getServiceManager()->get('Ololz\Service\Persist\Mapping');
        /* @var $mapService \Ololz\Service\Persist\Map */
        $mapService         = $this->getServiceManager()->get('Ololz\Service\Persist\Map');

        /* @var $lolKingSource \Ololz\Entity\Source */
        $lolKingSource      = $this->getServiceManager()->get('Ololz\Mapper\Source')->findOneByCode(Entity\Source::CODE_LOLKING);
        /* @var $smiteSpell \Ololz\Entity\Spell */
        $smiteSpell         = $this->getServiceManager()->get('Ololz\Mapper\Spell')->findOneByCode('smite');
        /* @var $junglerPosition \Ololz\Entity\Position */
        $junglerPosition    = $this->getServiceManager()->get('Ololz\Mapper\Position')->findOneByCode('jungle');

        /* @var $summoner \Ololz\Entity\Summoner */
        foreach ($summonerService->getMapper()->findByActive(true) as $summoner) {

            if (! $summoner->getMappingBySource($lolKingSource, 'id')) {
                continue;
            }

            $html = file_get_contents('http://www.lolking.net/summoner/euw/' . $summoner->getMappingBySource($lolKingSource)->getTheirs());

            $doc = \phpQuery::newDocumentHTML($html);
            \phpQuery::selectDocument($doc);

            $summonerHtml = pq('.summoner_titlebar div:eq(1) div:eq(0)');
            $summonerName = $summonerHtml->text();

            $history = pq('.tabs2_container .pane_inner:eq(3)');

            $actualInvocation = null;

            foreach ($history['> div'] as $cptMatch => $htmlMatch) {
//                if ($cptMatch != 3) {
//                    continue;
//                }

                $htmlMatch = pq($htmlMatch);

                $match      = new Entity\Match;
                $teammates  = new Entity\MatchTeam;
                $teammates->setMatch($match);
                $ennemies   = new Entity\MatchTeam;
                $ennemies->setMatch($match);

                foreach ($htmlMatch['.match_details_extended table table:eq(0) tr'] as $keyTeammate => $htmlTeammate) {
                    if ($keyTeammate == 0) {
                        continue;
                    }
                    $htmlTeammate = pq($htmlTeammate);

                    $teammateSummoner = new Entity\Summoner;
                    $teammateSummoner->setName($htmlTeammate['td:eq(1)']->text())
                                     ->setRealm($summoner->getRealm())
                                     ->setActive(false);

                    if ($teammateSummonerExists = $summonerService->exists($teammateSummoner)) {
                        $teammateSummoner = $teammateSummonerExists;
                    }

                    $teammate = new Entity\Invocation;
                    $teammate->setSummoner($teammateSummoner);

                    $lolKingChampion = str_replace('/champions/', '', $htmlTeammate['td:eq(0) a']->attr('href'));
                    $champion = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_CHAMPION, Entity\Mapping::COLUMN_CODE, $lolKingChampion);

                    if (!$champion) {
                        continue;
                    }

                    $teammate->setChampion($champion);

                    $teammate->setMatchTeam($teammates);

                    if ($teammateSummoner->getName() == $summonerName) {
                        $actualInvocation = $teammate;
                        $actualInvocation->setSummoner($summoner);
                    }
                }

                foreach ($htmlMatch['.match_details_extended table table:eq(1) tr'] as $keyEnnemy => $htmlEnnemy) {
                    if ($keyEnnemy == 0) {
                        continue;
                    }
                    $htmlEnnemy = pq($htmlEnnemy);

                    $ennemySummoner = new Entity\Summoner;
                    $ennemySummoner->setName($htmlEnnemy['td:eq(1)']->text())
                                   ->setRealm($summoner->getRealm())
                                   ->setActive(false);

                    if ($ennemySummonerExists = $summonerService->exists($ennemySummoner)) {
                        $ennemySummoner = $ennemySummonerExists;
                    }

                    $ennemy = new Entity\Invocation;
                    $ennemy->setSummoner($ennemySummoner);

                    $lolKingChampion = str_replace('/champions/', '', $htmlEnnemy['td:eq(0) a']->attr('href'));
                    $champion = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_CHAMPION, Entity\Mapping::COLUMN_CODE, $lolKingChampion);

                    if (!$champion) {
                        continue;
                    }

                    $ennemy->setChampion($champion);

                    $ennemy->setMatchTeam($ennemies);
                }

                foreach ($htmlMatch['.match_details_cell'] as $keyDetails => $details) {
                    $details = pq($details);

                    switch ($keyDetails)
                    {
                        case 0: // Champion
            //                $game['champion'] = str_replace('/champions/', '', pq($details['a'])->attr('href'));
                        break;

                        case 1: // Type
                            { // Match type
                                $lolKingMatchType = $details['div div:eq(0)']->text();
                                $matchType = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_MATCH_TYPE, Entity\Mapping::COLUMN_CODE, $lolKingMatchType);
                                if ($matchType) {
                                    $match->setMatchType($matchType);
                                }
                            }
                            { // Result loser / winner
                                if ($details['div div:eq(1)']->text() == 'Loss') {
                                    $match->setWinner($ennemies);
                                    $match->setLoser($teammates);
                                } else {
                                    $match->setWinner($teammates);
                                    $match->setLoser($ennemies);
                                }
                            }
                            { // Date
                                $match->setDate(new \DateTime($details['div div:eq(2) span']->attr('data-hoverswitch')));
                            }
                        break;

                        case 2: // Length
                            $length = (int) str_replace(' mins', '', $details['div strong']->text());
                            $match->setLength($length);
                        break;

                        case 3: // KDA
                            $actualInvocation->setKills((int) $details['strong:eq(0)']->text());
                            $actualInvocation->setDeaths((int) $details['strong:eq(1)']->text());
                            $actualInvocation->setAssists((int) $details['strong:eq(2)']->text());
                        break;

                        case 4: // Gold
                            $actualInvocation->setGold((float) $details['strong']->text());
                        break;

                        case 5: // Minions
                            $actualInvocation->setMinions((int) $details['strong']->text());
                        break;

                        case 6: // Spells
                            foreach ($details['div.icon_36'] as $htmlSpell) {
                                $htmlSpell = pq($htmlSpell)->attr('style');
                                $lolKingSpell = substr($htmlSpell, strrpos($htmlSpell, '/') + 1, strrpos($htmlSpell, '.') - 1 - strrpos($htmlSpell, '/'));
                                $spell = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_SPELL, Entity\Mapping::COLUMN_ID, $lolKingSpell);
                                if ($spell) {
                                    $actualInvocation->addSpell($spell);
                                }
                            }
                        break;

                        case 7: // Items
                            foreach ($details['div.icon_32 a'] as $htmlItem) {
                                $htmlItem = pq($htmlItem);
                                $lolKingItem = str_replace('/items/', '', $htmlItem->attr('href'));
                                $item = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_ITEM, Entity\Mapping::COLUMN_ID, $lolKingItem);
                                if ($item) {
                                    $actualInvocation->addItem($item);
                                }
                            }
                        break;
                    }
                }

                // Summoner personnal stats

                foreach ($htmlMatch['.match_details_extended_stats td'] as $keyStats => $summonerStats) {
                    $summonerStats = pq($summonerStats);

                    switch ($keyStats)
                    {
                        case 0: // Damage dealt
                            $actualInvocation->setDamageDealt((float) str_replace(',', '.', $summonerStats->text()));
                        break;
                        case 1: // Damage received
                            $actualInvocation->setDamageReceived((float) str_replace(',', '.', $summonerStats->text()));
                        break;
                        case 2: // Healing done
                            $actualInvocation->setHealingDone((float) str_replace(',', '.', $summonerStats->text()));
                        break;
                        case 3: // Largest multi-kill
                            $actualInvocation->setLargestMultiKill((int) $summonerStats->text());
                        break;
                        case 4: // Time spent dead
                            $actualInvocation->setTimeSpentDead((int) $summonerStats->text());
                        break;
                        case 5: // Turrets destroyed
                            $actualInvocation->setTurretsDestroyed((int) $summonerStats->text());
                        break;
                    }
                }

                $actualInvocation->setPosition($actualInvocation->hasSpell($smiteSpell) ? $junglerPosition : $actualInvocation->getChampion()->getPosition());

                if ($map = $match->getMatchType()->getMap()) {
                    $match->setMap($map);
                } else {
                    if (count($match->getWinner()->getInvocations()) == 3) {
                        $match->setMap($mapService->getMapper()->findOneByCode('twisted-treeline'));
                    }
                }

                $em->persist($match);

                $matchService->save($match, true);
                $this->getLogger()->info('Match : ' . (string) $match . ' saved.');

                break 2;
            }
        }
    }
}
