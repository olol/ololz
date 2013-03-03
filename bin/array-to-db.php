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
 * @param \Ololz\Entity\Spell               $smiteSpell
 * @param \Ololz\Entity\Position            $junglerPosition
 *
 * @return \Ololz\Entity\Invocation
 */
function fillUpInvocation($aInvocationName, $aInvocation, $lolKingSource, $mappingService, $summonerService, $smiteSpell, $junglerPosition)
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

    if ($invocation->hasSpell($smiteSpell)) {
        $invocation->setPosition($junglerPosition);
    } else if ($invocation->getChampion()) {
        $invocation->setPosition($invocation->getChampion()->getPosition());
    }


    return $invocation;
}

/* @var $em \Doctrine\ORM\EntityManager */
$em                 = $application->getServiceManager()->get('doctrine.entitymanager.orm_default');
/* @var $summonerService \Ololz\Service\Persist\Summoner */
$summonerService    = $application->getServiceManager()->get('Ololz\Service\Persist\Summoner');
/* @var $mappingService \Ololz\Service\Persist\Mapping */
$mappingService     = $application->getServiceManager()->get('Ololz\Service\Persist\Mapping');
/* @var $matchService \Ololz\Service\Persist\Match */
$matchService       = $application->getServiceManager()->get('Ololz\Service\Persist\Match');
/* @var $lolKingSource \Ololz\Entity\Source */
$lolKingSource      = $application->getServiceManager()->get('Ololz\Mapper\Source')->findOneByCode(Entity\Source::CODE_LOLKING);
/* @var $smiteSpell \Ololz\Entity\Spell */
$smiteSpell         = $application->getServiceManager()->get('Ololz\Mapper\Spell')->findOneByCode('smite');
/* @var $junglerPosition \Ololz\Entity\Position */
$junglerPosition    = $application->getServiceManager()->get('Ololz\Mapper\Position')->findOneByCode('jungle');


foreach ($stats['matches'] as $aMatch) {
    $match = new Entity\Match;

    // Match type
    $matchType = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_MATCH_TYPE, $aMatch['type']);
    if ($matchType) {
        $match->setMatchType($matchType);

        // Match map
        if ($matchType->getMap()) {
            $match->setMap($matchType->getMap());
        }
    }

    // Match date
    $match->setDate(new \DateTime($aMatch['date'] . ' 00:00:00'));

    // Match length
    $match->setLength($aMatch['length']);

    // Match teammates team
    $teammateTeam = new Entity\MatchTeam;
    $teammateTeam->setMatch($match);
    foreach ($aMatch['teammates'] as $aTeammateName => $aTeammate) {
        $teammate = fillUpInvocation($aTeammateName, $aTeammate, $lolKingSource, $mappingService, $summonerService, $smiteSpell, $junglerPosition);
        $teammate->setMatchTeam($teammateTeam);
    }

    // Match ennemy team
    $ennemyTeam = new Entity\MatchTeam;
    $ennemyTeam->setMatch($match);
    foreach ($aMatch['ennemies'] as $aEnnemyName => $aEnnemy) {
        $ennemy = fillUpInvocation($aEnnemyName, $aEnnemy, $lolKingSource, $mappingService, $summonerService, $smiteSpell, $junglerPosition);
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

    $hash = $matchService->calculateHash($match);
    $existingMatch = $matchService->getMapper()->findOneByHash($hash);
    $match->setHash($hash);

    if ($existingMatch) {
        $em->detach($match);
        continue;
    }

//    $em->persist($match);
    $em->flush();

    $em->detach($match);
}
