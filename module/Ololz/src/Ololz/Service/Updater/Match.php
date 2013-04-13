<?php
namespace Ololz\Service\Updater;

use Ololz\Entity;

/**
 * Match updater
 *
 * I know it's very poorly coded, but i got tired of the doctrine entity "merge"
 * problem...
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Match extends Updater
{
    public function __construct()
    {
        set_time_limit(0);
    }

    /**
     * Default source to LoL King
     *
     * @return \Ololz\Entity\Source
     */
    public function getSource()
    {
        if (is_null($this->source)) {
            $this->setSource($this->getService('Source')->getMapper()->findOneByCode(Entity\Source::CODE_LOLKING));
        }

        return $this->source;
    }

    /**
     * @param array                     $array
     * @param \Ololz\Entity\Summoner    $summoner
     *
     * @return \Ololz\Entity\Summoner
     */
    protected function arraySummonerToEntity(array $array, Entity\Summoner $summoner = null)
    {
        if (is_null($summoner)) {
            $summoner = new Entity\Summoner;
        }

        $summoner->setName($array['name'])
                 ->setRealm($array['realm'])
                 ->setActive(false);

        return $summoner;
    }

    /**
     * @param array                     $array
     * @param string                    $realm
     * @param \Ololz\Entity\Invocation  $invocation
     *
     * @return \Ololz\Entity\Invocation
     */
    protected function arrayInvocationToEntity(array $array, $realm, Entity\Invocation $invocation = null)
    {
        if (is_null($invocation)) {
            $invocation = new Entity\Invocation;
        }

        $summoner = $array['summoner'] instanceof Entity\Summoner ? $array['summoner'] : $this->getService('Summoner')->getMapper()->findOneBy(array('name' => $array['summoner']['name'], 'realm' => $realm));
        if (! $summoner) {
            $array['summoner']['realm'] = $realm;
            $summoner = $this->arraySummonerToEntity($array['summoner']);
        }

        $invocation->setSummoner($summoner)
                   ->setChampion($array['champion']);

        if (array_key_exists('kills', $array)) {
            $invocation->setAssists(array_key_exists('assists', $array) ? $array['assists'] : null)
                       ->setDamageDealt(array_key_exists('damageDealt', $array) ? $array['damageDealt'] : null)
                       ->setDamageReceived(array_key_exists('damageReceived', $array) ? $array['damageReceived'] : null)
                       ->setDeaths(array_key_exists('deaths', $array) ? $array['deaths'] : null)
                       ->setGold(array_key_exists('gold', $array) ? $array['gold'] : null)
                       ->setHealingDone(array_key_exists('healingDone', $array) ? $array['healingDone'] : null)
                       ->setKills(array_key_exists('kills', $array) ? $array['kills'] : null)
                       ->setLargestMultiKill(array_key_exists('largestMultiKill', $array) ? $array['largestMultiKill'] : null)
                       ->setMinions(array_key_exists('minions', $array) ? $array['minions'] : null)
                       ->setPosition(array_key_exists('position', $array) ? $array['position'] : null)
                       ->setItems(array_key_exists('items', $array) ? $array['items'] : null)
                       ->setSpells(array_key_exists('spells', $array) ? $array['spells'] : null);
        }

        return $invocation;
    }

    /**
     * @param array     $array
     * @param string    $realm
     *
     * @return \Ololz\Entity\Match
     */
    protected function arrayMatchToEntity(array $array, $realm)
    {
        $match = new Entity\Match;
        $match->setDate($array['date'])
              ->setLength($array['length'])
              ->setMatchType($array['matchType']);
        if (array_key_exists('map', $array)) {
            $match->setMap($array['map']);
        }

        $winners = new Entity\MatchTeam;
        $winners->setMatch($match);
        foreach ($array['winner'] as $arrayInvo) {
            $invocation = $this->arrayInvocationToEntity($arrayInvo, $realm);
            $invocation->setMatchTeam($winners);
        }
        $match->setWinner($winners);

        $losers = new Entity\MatchTeam;
        $losers->setMatch($match);
        foreach ($array['loser'] as $arrayInvo) {
            $invocation = $this->arrayInvocationToEntity($arrayInvo, $realm);
            $invocation->setMatchTeam($losers);
        }
        $match->setLoser($losers);

        return $match;
    }

    /**
     * @param string                    $name
     * @param \Ololz\Entity\MatchTeam   $matchTeam
     *
     * @return \Ololz\Entity\Invocation
     */
    protected function findInvocationFromSummonerName($name, Entity\MatchTeam $matchTeam)
    {
        foreach ($matchTeam->getInvocations() as $invocation) {
            if ($invocation->getSummoner()->getName() == $name) {
                return $invocation;
            }
        }

        return null;
    }

    /**
     * @param string                    $lolKingId
     * @param \Ololz\Entity\MatchTeam   $matchTeam
     *
     * @return \Ololz\Entity\Invocation
     */
    protected function findInvocationFromSummonerLolKingId($lolKingId, Entity\MatchTeam $matchTeam)
    {
        $mappingMapper = $this->getService('Mapping')->getMapper();
        foreach ($matchTeam->getInvocations() as $invocation) {
            $mappedLolKingId = $mappingMapper->findOneTheirs($this->getSource(), Entity\Mapping::TYPE_SUMMONER, Entity\Mapping::COLUMN_ID, $invocation->getSummoner());
            if ($mappedLolKingId == $lolKingId) {
                return $invocation;
            }
        }

        return null;
    }

    /**
     * @param array                     $array
     * @param \Ololz\Entity\MatchTeam   $matchTeam
     * @param string                    $realm
     *
     * @return \Ololz\Entity\MatchTeam
     */
    protected function mergeMatchTeamFromArray($array, Entity\MatchTeam $matchTeam, $realm)
    {
        foreach ($array as $arrayInvo) {
            // 1st look if we can find the invocation thanks to its summoner LolKing ID
            if ($arrayInvo['summoner'] instanceof Entity\Summoner) {
                $lolKingId = $this->getService('Mapping')->getMapper()->findOneTheirs($this->getSource(), Entity\Mapping::TYPE_SUMMONER, Entity\Mapping::COLUMN_ID, $arrayInvo['summoner']);
            } else {
                $lolKingId = $arrayInvo['summoner']['lolKingId'];
            }
            $invocation = $this->findInvocationFromSummonerLolKingId($lolKingId, $matchTeam);

            // If not, try by its name
//            if (! $invocation instanceof Entity\Invocation) {
                $name = $arrayInvo['summoner'] instanceof Entity\Summoner ? $arrayInvo['summoner']->getName() : $arrayInvo['summoner']['name'];
                $invocation = $this->findInvocationFromSummonerName($name, $matchTeam);
//            }

            if ($invocation instanceof Entity\Invocation && is_null($invocation->getKills()) && array_key_exists('kills', $arrayInvo)) {
                $invocation = $this->arrayInvocationToEntity($arrayInvo, $realm, $invocation);
            }
        }

        return $matchTeam;
    }

    /**
     * Merging a match consists mostly of finding new invocations that have more
     * data than those that already exists in the entity. All other data should
     * be the same already.
     *
     * @param array                 $array
     * @param \Ololz\Entity\Match   $match
     * @param string                $realm
     *
     * @return \Ololz\Entity\Match
     */
    protected function mergeMatchFromArray($array, Entity\Match $match, $realm)
    {
        $match->setWinner($this->mergeMatchTeamFromArray($array['winner'], $match->getWinner(), $realm));
        $match->setLoser( $this->mergeMatchTeamFromArray($array['loser'],  $match->getLoser(),  $realm));

        return $match;
    }

    /**
     * @param array $match
     *
     * @return string
     */
    protected function calculateHashFromArray($match)
    {
        $string = '';

        $invocations = array_merge($match['teammates'], $match['ennemies']);

        // Sort all invocations with same order
        usort($invocations, function($a, $b) {
            $aName = $a['summoner'] instanceof Entity\Summoner ? $a['summoner']->getName() : $a['summoner']['name'];
            $bName = $b['summoner'] instanceof Entity\Summoner ? $b['summoner']->getName() : $b['summoner']['name'];
            return strcasecmp($aName, $bName);
        } );

        foreach ($invocations as $summonerName => $invocation) {
            $string .= ($invocation['summoner'] instanceof Entity\Summoner ? $invocation['summoner']->getName() : $invocation['summoner']['name']) .
                       $invocation['champion']->getCode();
        }

        $string .= $match['matchType']->getCode();
        $string .= $match['length'];
        $string .= $match['date']->format('Y-m-d\TH:i');

        $hash = hash('md5', $string);

        return $hash;
    }

    /**
     * Can't directly use entities because of weird Doctrine behavior while
     * merging with existing matches (or more likely because of my poor
     * knowledge of Doctrine), so we're passing by arrays 1st.
     */
    public function update()
    {
        $em = $this->getServiceManager()->get('doctrine.entitymanager.orm_default');

        $positionsByKey     = $this->getService('Position')->getMapper()->findWithKey('code', null);
        $supportSpells      = $this->getService('Spell')->getMapper()->findBy(array('code' => array('clairvoyance', 'exhaust', 'heal')));
        /* @var $smiteSpell \Ololz\Entity\Spell */
        $smiteSpell         = $this->getService('Spell')->getMapper()->findOneByCode('smite');

        /* @var $summoner \Ololz\Entity\Summoner */
        foreach ($this->getService('Summoner')->getMapper()->findByActive(true) as $summoner) {

            // Skip summoners for whom we don't have a LolKing ID
            if (! $summonerMapping = $summoner->getMappingBySource($this->getSource(), 'id')) {
                continue;
            }

            $html = file_get_contents('http://www.lolking.net/summoner/' . $summoner->getRealm() . '/' . $summonerMapping->getTheirs());

            $doc = \phpQuery::newDocumentHTML($html);
            \phpQuery::selectDocument($doc);

            foreach (pq('.tabs2 li a') as $cptTab => $tab) {
                if (pq($tab)->attr('id') == 'hash-history') {
                    break;
                }
            }

            $summonerHtml = pq('.summoner_titlebar div:eq(1) div:eq(0)');
            $summonerName = $summonerHtml->text();

            $history = pq('.tabs2_container .pane_inner:eq(' . $cptTab . ')');

            $actualInvocation = null;

            foreach ($history['> div'] as $cptMatch => $htmlMatch) {

                $htmlMatch = pq($htmlMatch);

//                $match      = new Entity\Match;
                $match      = array();
//                $teammates  = new Entity\MatchTeam;
//                $teammates->setMatch($match);
                $teammates = array();
                $match['teammates'] = &$teammates;
//                $ennemies   = new Entity\MatchTeam;
//                $ennemies->setMatch($match);
                $ennemies = array();
                $match['ennemies'] = &$ennemies;

                foreach ($htmlMatch['.match_details_extended table table:eq(0) tr'] as $keyTeammate => $htmlTeammate) {
                    if ($keyTeammate == 0) {
                        continue;
                    }
                    $htmlTeammate = pq($htmlTeammate);

//                    $teammateSummoner = new Entity\Summoner;
//                    $teammateSummoner->setName($htmlTeammate['td:eq(1)']->text())
//                                     ->setRealm($summoner->getRealm())
//                                     ->setActive(false);

                    $teammateSummoner = array(
                        'name'      => $htmlTeammate['td:eq(1)']->text(),
                        'realm'     => $summoner->getRealm(),
                        'active'    => false,
                        'lolKingId' => str_replace('/summoner/' . $summoner->getRealm() . '/', '', $htmlTeammate['td:eq(1) a']->attr('href')) // Doesn't exist for actual summoner
                    );

//                    if ($teammateSummonerExists = $this->getService('Summoner')->exists($teammateSummoner)) {
//                        $teammateSummoner = $teammateSummonerExists;
//                    }

//                    $teammate = new Entity\Invocation;
//                    $teammate->setSummoner($teammateSummoner);
                    $teammate = array(
                        'summoner'  => $teammateSummoner
                    );

                    $lolKingChampion = str_replace('/champions/', '', $htmlTeammate['td:eq(0) a']->attr('href'));
                    $champion = $this->getService('Mapping')->getMapper()->findOneOurs($this->getSource(), Entity\Mapping::TYPE_CHAMPION, Entity\Mapping::COLUMN_CODE, $lolKingChampion);

                    if (! $champion) {
                        continue;
                    }

//                    $teammate->setChampion($champion);
                    $teammate['champion'] = $champion;

//                    $teammate->setMatchTeam($teammates);
                    $teammates[] = $teammate;

//                    if ($teammateSummoner->getName() == $summonerName) {
//                        $actualInvocation = $teammate;
//                        $actualInvocation->setSummoner($summoner);
//                    }
                    if (empty($teammateSummoner['lolKingId'])) { // If empty, it's the actual summoner
                        $actualInvocation = &$teammates[0];
                        $actualInvocation['summoner'] = $summoner;
                    }
                }

                foreach ($htmlMatch['.match_details_extended table table:eq(1) tr'] as $keyEnnemy => $htmlEnnemy) {
                    if ($keyEnnemy == 0) {
                        continue;
                    }
                    $htmlEnnemy = pq($htmlEnnemy);

//                    $ennemySummoner = new Entity\Summoner;
//                    $ennemySummoner->setName($htmlEnnemy['td:eq(1)']->text())
//                                   ->setRealm($summoner->getRealm())
//                                   ->setActive(false);
                    $ennemySummoner = array(
                        'name'      => $htmlEnnemy['td:eq(1)']->text(),
                        'realm'     => $summoner->getRealm(),
                        'active'    => false,
                        'lolKingId' => str_replace('/summoner/' . $summoner->getRealm() . '/', '', $htmlTeammate['td:eq(1) a']->attr('href'))
                    );

//                    if ($ennemySummonerExists = $this->getService('Summoner')->exists($ennemySummoner)) {
//                        $ennemySummoner = $ennemySummonerExists;
//                    }

//                    $ennemy = new Entity\Invocation;
//                    $ennemy->setSummoner($ennemySummoner);
                    $ennemy = array(
                        'summoner'  => $ennemySummoner
                    );

                    $lolKingChampion = str_replace('/champions/', '', $htmlEnnemy['td:eq(0) a']->attr('href'));
                    $champion = $this->getService('Mapping')->getMapper()->findOneOurs($this->getSource(), Entity\Mapping::TYPE_CHAMPION, Entity\Mapping::COLUMN_CODE, $lolKingChampion);

                    if (! $champion) {
                        continue;
                    }

//                    $ennemy->setChampion($champion);
                    $ennemy['champion'] = $champion;

//                    $ennemy->setMatchTeam($ennemies);
                    $ennemies[] = $ennemy;
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
                                $lolKingMatchType = trim($details['div div:eq(0)']->text());
                                $matchType = $this->getService('Mapping')->getMapper()->findOneOurs($this->getSource(), Entity\Mapping::TYPE_MATCH_TYPE, Entity\Mapping::COLUMN_CODE, $lolKingMatchType);
                                if ($matchType) {
//                                    $match->setMatchType($matchType);
                                    $match['matchType'] = $matchType;
                                } else {
                                    throw new \Exception('Can not find " ' . $lolKingMatchType . '" match type from LoL King.');
                                }
                            }
                            { // Result loser / winner
                                if ($details['div div:eq(1)']->text() == 'Loss') {
//                                    $match->setWinner($ennemies);
//                                    $match->setLoser($teammates);
                                    $match['winner'] = &$ennemies;
                                    $match['loser'] = &$teammates;
                                } else {
//                                    $match->setWinner($teammates);
//                                    $match->setLoser($ennemies);
                                    $match['winner'] = &$teammates;
                                    $match['loser'] = &$ennemies;
                                }
                            }
                            { // Date
//                                $match->setDate(new \DateTime($details['div div:eq(2) span']->attr('data-hoverswitch')));
                                $match['date'] = new \DateTime($details['div div:eq(2) span']->attr('data-hoverswitch'));
                            }
                        break;

                        case 2: // Length
                            $length = (int) str_replace(' mins', '', $details['div strong']->text());
//                            $match->setLength($length);
                            $match['length'] = $length;
                        break;

                        case 3: // KDA
//                            $actualInvocation->setKills((int) $details['strong:eq(0)']->text());
//                            $actualInvocation->setDeaths((int) $details['strong:eq(1)']->text());
//                            $actualInvocation->setAssists((int) $details['strong:eq(2)']->text());
                            $actualInvocation['kills'] = (int) $details['strong:eq(0)']->text();
                            $actualInvocation['deaths'] = (int) $details['strong:eq(1)']->text();
                            $actualInvocation['assists'] = (int) $details['strong:eq(2)']->text();
                        break;

                        case 4: // Gold
//                            $actualInvocation->setGold((float) $details['strong']->text());
                            $actualInvocation['gold'] = (float) $details['strong']->text();
                        break;

                        case 5: // Minions
//                            $actualInvocation->setMinions((int) $details['strong']->text());
                            $actualInvocation['minions'] = (int) $details['strong']->text();
                        break;

                        case 6: // Spells
                            foreach ($details['div.icon_36'] as $htmlSpell) {
                                $htmlSpell = pq($htmlSpell)->attr('style');
                                $lolKingSpell = substr($htmlSpell, strrpos($htmlSpell, '/') + 1, strrpos($htmlSpell, '.') - 1 - strrpos($htmlSpell, '/'));
                                $spell = $this->getService('Mapping')->getMapper()->findOneOurs($this->getSource(), Entity\Mapping::TYPE_SPELL, Entity\Mapping::COLUMN_ID, $lolKingSpell);
                                if ($spell) {
//                                    $actualInvocation->addSpell($spell);
                                    $actualInvocation['spells'][] = $spell;
                                }
                            }
                        break;

                        case 7: // Items
                            foreach ($details['div.icon_32 a'] as $htmlItem) {
                                $htmlItem = pq($htmlItem);
                                $lolKingItem = str_replace('/items/', '', $htmlItem->attr('href'));
                                $item = $this->getService('Mapping')->getMapper()->findOneOurs($this->getSource(), Entity\Mapping::TYPE_ITEM, Entity\Mapping::COLUMN_ID, $lolKingItem);
                                if ($item) {
//                                    $actualInvocation->addItem($item);
                                    $actualInvocation['items'][] = $item;
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
//                            $actualInvocation->setDamageDealt((float) str_replace(',', '.', $summonerStats->text()));
                            $actualInvocation['damageDealt'] = (float) str_replace(',', '.', $summonerStats->text());
                        break;
                        case 1: // Damage received
//                            $actualInvocation->setDamageReceived((float) str_replace(',', '.', $summonerStats->text()));
                            $actualInvocation['damageReceived'] = (float) str_replace(',', '.', $summonerStats->text());
                        break;
                        case 2: // Healing done
//                            $actualInvocation->setHealingDone((float) str_replace(',', '.', $summonerStats->text()));
                            $actualInvocation['healingDone'] = (float) str_replace(',', '.', $summonerStats->text());
                        break;
                        case 3: // Largest multi-kill
//                            $actualInvocation->setLargestMultiKill((int) $summonerStats->text());
                            $actualInvocation['largestMultiKill'] = (int) $summonerStats->text();
                        break;
                        case 4: // Time spent dead
//                            $actualInvocation->setTimeSpentDead((int) $summonerStats->text());
                            $actualInvocation['timeSpentDead'] = (int) $summonerStats->text();
                        break;
                        case 5: // Turrets destroyed
//                            $actualInvocation->setTurretsDestroyed((int) $summonerStats->text());
                            $actualInvocation['turretsDestroyed'] = (int) $summonerStats->text();
                        break;
                    }
                }

//                $actualInvocation->setPosition($actualInvocation->hasSpell($smiteSpell) ? $junglerPosition : $actualInvocation->getChampion()->getPosition());
//                $hasSmiteSpell = false;
//                foreach ($actualInvocation['spells'] as $invocationSpell) {
//                    if ($invocationSpell == $smiteSpell) {
//                        $hasSmiteSpell = true;
//                    }
//                }
//
//                $actualInvocation['position'] = $hasSmiteSpell ? $junglerPosition : $actualInvocation['champion']->getPosition();

//                if ($map = $match->getMatchType()->getMap()) {
//                    $match->setMap($map);
//                } else {
//                    if (count($match->getWinner()->getInvocations()) == 3) {
//                        $match->setMap($this->getService('Map')->getMapper()->findOneByCode('twisted-treeline'));
//                    }
//                }
                if ($map = $match['matchType']->getMap()) {
//                    $match->setMap($map);
                    $match['map'] = $map;
                } else {
//                    if (count($match->getWinner()->getInvocations()) == 3) {
//                        $match->setMap($this->getService('Map')->getMapper()->findOneByCode('twisted-treeline'));
//                    }
                    if (count($match['winner']) == 3) {
//                        $match->setMap($this->getService('Map')->getMapper()->findOneByCode('twisted-treeline'));
                        $match['map'] = $this->getService('Map')->getMapper()->findOneByCode('twisted-treeline');
                    }
                }

                $hash = $this->calculateHashFromArray($match);

                $action = '';
                if ($existing = $this->getService('Match')->getMapper()->findOneByHash($hash)) {
                    $match = $this->mergeMatchFromArray($match, $existing, $summoner->getRealm());
                    $action = 'updated';
                } else {
                    $match = $this->arrayMatchToEntity($match, $summoner->getRealm());
                    $match->setHash($this->getService('Match')->calculateHash($match));
                    $em->persist($match);
                    $action = 'saved';
                }

                // Let's try to guess real positions of the players
                if ($match->getWinner()) {
                    $this->getService('MatchTeam')->guessTeamPositions($match->getWinner(), $smiteSpell, $supportSpells, $positionsByKey);
                }
                if ($match->getLoser()) {
                    $this->getService('MatchTeam')->guessTeamPositions($match->getLoser(),  $smiteSpell, $supportSpells, $positionsByKey);
                }

                $em->flush();

                $this->getLogger()->info('Match : ' . (string) $match . ' ' . $action . '.');
            }
        }
    }
}
