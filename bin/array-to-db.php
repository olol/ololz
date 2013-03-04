<?php

require __DIR__ . '/../autoload_init.php';
@include_once(__DIR__ . '/../data/stats.php');

\Zend\Loader\AutoloaderFactory::factory();

$application = \Zend\Mvc\Application::init(include 'config/application.config.php');

use Ololz\Entity;


/**
 * @param string                            $aInvocationName
 * @param array                             $aInvocation
 * @param \Ololz\Entity\Source              $lolKingSource
 * @param \Ololz\Service\Persist\Mapping    $mappingService
 * @param \Ololz\Service\Persist\Summoner   $summonerService
 *
 * @return \Ololz\Entity\Invocation
 */
function fillUpInvocation($aInvocationName, $aInvocation, $lolKingSource, $mappingService, $summonerService)
{
    $invocationVals = array('champion', 'kills', 'deaths', 'assists', 'gold', 'minions', 'spells', 'items', 'damageDealt', 'damageReceived', 'healingDone', 'largestMultiKill', 'timeSpentDead', 'turretsDestroyed');
    $invocation = new Entity\Invocation;

    $summoner = $summonerService->getMapper()->findOneBy(array('name' => $aInvocationName, 'realm' => Entity\Summoner::REALM_EUW));
    if (! $summoner) {
        $summoner = new Entity\Summoner;
        $summoner->setName($aInvocationName)
                 ->setRealm(Entity\Summoner::REALM_EUW)
                 ->setActive(false);
    }
    $invocation->setSummoner($summoner);

    foreach ($invocationVals as $key) {
        if (array_key_exists($key, $aInvocation)) {
            $val = $aInvocation[$key];
            switch ($key) {
                case 'champion':
                    $champion = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_CHAMPION, $val);
                    if ($champion) {
                        $invocation->setChampion($champion);
                    }
                break;

                case 'spells':
                    foreach ($val as $aSpell) {
                        $spell = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_SPELL, $aSpell);
                        if ($spell) {
                            $invocation->addSpell($spell);
                        }
                    }
                break;

                case 'items':
                    $summoner->setActive(true);
                    foreach ($val as $aItem) {
                        $item = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_ITEM, $aItem);
                        if ($item) {
                            $invocation->addItem($item);
                        }
                    }
                break;

                default:
                    $getter = 'set' . ucfirst($key);
                    $invocation->$getter($val);
                break;
            }
        }
    }

    // Default champion position ; "real" position will be guessed later once whole team is there
    if ($invocation->getChampion()) {
        $invocation->setPosition($invocation->getChampion()->getPosition());
    }

    return $invocation;
}

/**
 * @param \Ololz\Entity\MatchTeam $matchTeam
 * @param \Ololz\Entity\Position $position
 */
function teamHasMoreThanOnePosition($matchTeam, $position) {
    $ofPosition = array();

    /* @var $invocation \Ololz\Entity\Invocation */
    foreach ($matchTeam->getInvocations() as $invocation) {
        if ($invocation->getPosition() == $position) {
            $ofPosition[] = $invocation;
        }
    }

    return count($ofPosition) > 1 ? $ofPosition : false;
}

/**
 * @param \Ololz\Entity\MatchTeam   $matchTeam
 * @param \Ololz\Entity\Spell       $smiteSpell
 * @param array                     $supportSpells
 * @param array                     $positionsByKey
 */
function guessTeamPositions($matchTeam, $smiteSpell, $supportSpells, $positionsByKey) {
    $invocations = $matchTeam->getInvocations();

    /* @var $invocation \Ololz\Entity\Invocation */
    // Easy one, let's get the jungler !
    foreach ($invocations as $invocation) {
        if ($invocation->hasSpell($smiteSpell)) {
            $invocation->setPosition($positionsByKey['jungle']);
        }
    }

    // Now, if we have more than 1 player with the same position, we check if
    // one of them has a "support" spell such has exhaust or heal or
    // clairvoyance
    foreach ($positionsByKey as $position) {
        $ofSamePosition = teamHasMoreThanOnePosition($matchTeam, $position);
        if ($ofSamePosition) {
            foreach ($ofSamePosition as $invocation) {
                foreach ($supportSpells as $supportSpell) {
                    if ($invocation->hasSpell($supportSpell)) {
                        // If we found him, there's no other... Hopefully !
                        $invocation->setPosition($positionsByKey['support']);
                        break 3;
                    }
                }
            }
        }
    }
}

/* @var $em \Doctrine\ORM\EntityManager */
$em                 = $application->getServiceManager()->get('doctrine.entitymanager.orm_default');
/* @var $summonerService \Ololz\Service\Persist\Summoner */
$summonerService    = $application->getServiceManager()->get('Ololz\Service\Persist\Summoner');
/* @var $mappingService \Ololz\Service\Persist\Mapping */
$mappingService     = $application->getServiceManager()->get('Ololz\Service\Persist\Mapping');
/* @var $matchService \Ololz\Service\Persist\Match */
$matchService       = $application->getServiceManager()->get('Ololz\Service\Persist\Match');
/* @var $positionService \Ololz\Service\Persist\Match */
$positionService       = $application->getServiceManager()->get('Ololz\Service\Persist\Position');
/* @var $spellService \Ololz\Service\Persist\Spell */
$spellService       = $application->getServiceManager()->get('Ololz\Service\Persist\Spell');
/* @var $lolKingSource \Ololz\Entity\Source */
$lolKingSource      = $application->getServiceManager()->get('Ololz\Mapper\Source')->findOneByCode(Entity\Source::CODE_LOLKING);
/* @var $smiteSpell \Ololz\Entity\Spell */
$smiteSpell         = $spellService->getMapper()->findOneByCode('smite');
/* @var $twistedMap \Ololz\Entity\Map */
$twistedMap         = $application->getServiceManager()->get('Ololz\Mapper\Map')->findOneByCode('twisted-treeline');

$positionsByKey = $positionService->getMapper()->findWithKey('code', null);
$supportSpells = $spellService->getMapper()->findBy(array('code' => array('clairvoyance', 'exhaust', 'heal')));

foreach ($stats['matches'] as $aMatch) {
    $match = new Entity\Match;

    // Match date
    $match->setDate(new \DateTime($aMatch['date'] . ' 00:00:00'));

    // Match length
    $match->setLength($aMatch['length']);

    // Match teammates team
    $teammateTeam = new Entity\MatchTeam;
    $teammateTeam->setMatch($match);
    foreach ($aMatch['teammates'] as $aTeammateName => $aTeammate) {
        $teammate = fillUpInvocation($aTeammateName, $aTeammate, $lolKingSource, $mappingService, $summonerService);
        $teammate->setMatchTeam($teammateTeam);
    }

    // Match ennemy team
    $ennemyTeam = new Entity\MatchTeam;
    $ennemyTeam->setMatch($match);
    foreach ($aMatch['ennemies'] as $aEnnemyName => $aEnnemy) {
        $ennemy = fillUpInvocation($aEnnemyName, $aEnnemy, $lolKingSource, $mappingService, $summonerService);
        $ennemy->setMatchTeam($ennemyTeam);
    }

    // Match result
    if ($aMatch['result'] == 'V') {
        $match->setWinner($teammateTeam);
        $match->setLoser($ennemyTeam);
    } else {
        $match->setWinner($ennemyTeam);
        $match->setLoser($teammateTeam);
    }

    // Match type
    $matchType = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_MATCH_TYPE, $aMatch['type']);
    if ($matchType) {
        $match->setMatchType($matchType);

        // Match map
        if ($matchType->getMap()) {
            $match->setMap($matchType->getMap());
        } else {
            if (count($aMatch['teammates']) == 3) {
                $match->setMap($twistedMap);
            }
        }
    }

    // Let's try to guess real positions of the players
    if ($match->getMap() && $match->getMap()->getCode() == 'summoner-s-rift') {
        guessTeamPositions($teammateTeam, $smiteSpell, $supportSpells, $positionsByKey);
        guessTeamPositions($ennemyTeam,   $smiteSpell, $supportSpells, $positionsByKey);
    }

    $hash = $matchService->calculateHash($match);
    $existingMatch = $matchService->getMapper()->findOneByHash($hash);
    $match->setHash($hash);

    if ($existingMatch) {
        $em->detach($match);
        continue;
    }

    $em->persist($match);
    $em->flush();

    $em->detach($match);
}
