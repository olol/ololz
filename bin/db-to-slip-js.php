<?php

require __DIR__ . '/../autoload_init.php';
@include_once(__DIR__ . '/../data/stats.php');

\Zend\Loader\AutoloaderFactory::factory();

$application = \Zend\Mvc\Application::init(include 'config/application.config.php');

use Ololz\Entity;

/**
 * @param string $championName
 *
 * @return string
 */
function slipizeChampionName($championName) {
    return str_replace(array("'", ' '), '', (string) $championName);
}

/**
 * @param \Ololz\Entity\Invocation $invocation
 * @param string $who
 * @param string $position
 *
 * @return string
 */
function getChampionNameOfPosition($invocation, $who, $position) {
    $team = $who == 'ennemy' ? $invocation->getMatchTeam()->getOpponent() : $invocation->getMatchTeam();
    foreach ($team->getInvocations() as $teamInvocation) {
        if ($teamInvocation != $invocation && $teamInvocation->getPosition()->getCode() == $position) {
            return $teamInvocation->getChampion()->getName();
        }
    }

    return null;
}

/* @var $em \Doctrine\ORM\EntityManager */
$em                 = $application->getServiceManager()->get('doctrine.entitymanager.orm_default');
/* @var $summonerService \Ololz\Service\Persist\Summoner */
$summonerService    = $application->getServiceManager()->get('Ololz\Service\Persist\Summoner');
/* @var $mappingService \Ololz\Service\Persist\Mapping */
$mappingService     = $application->getServiceManager()->get('Ololz\Service\Persist\Mapping');
/* @var $matchService \Ololz\Service\Persist\Match */
$matchService       = $application->getServiceManager()->get('Ololz\Service\Persist\Match');

$data = array();

$summoners = $summonerService->getMapper()->findByActive(true);

$mappingPosition = array(
    'top'       => 'topLane',
    'mid'       => 'mid',
    'adc'       => 'adc',
    'support'   => 'supp',
    'jungle'    => 'junglers'
);

/* @var $summoner \Ololz\Entity\Summoner */
foreach ($summoners as $summoner) {
    /* @var $invocation \Ololz\Entity\Invocation */
    foreach ($summoner->getInvocations() as $invocation) {
        $summonerName = $summoner->getName();
        $position = $mappingPosition[$invocation->getPosition()->getCode()];
        $positionDataName = $position . $summonerName;
        if (!array_key_exists($positionDataName, $data)) {
            $data[$positionDataName] = array();
        }

        $championName = slipizeChampionName($invocation->getChampion()->getName());
        if (!array_key_exists($championName, $data[$positionDataName])) {
            $data[$positionDataName][$championName] = array();
        }

        $current = array(
            $invocation->getKills(),
            $invocation->getDeaths(),
            $invocation->getAssists(),
            $invocation->getMatchTeam()->getMatch()->getWinner() == $invocation->getMatchTeam() ? 'V' : 'D',
        );

        switch($invocation->getPosition()->getCode())
        {
            case 'top':
                $current[] = slipizeChampionName(getChampionNameOfPosition($invocation, 'ennemy', 'top'));
            break;
            case 'mid':
                $current[] = slipizeChampionName(getChampionNameOfPosition($invocation, 'ennemy','mid'));
            break;

            case 'adc':
                $current[] = slipizeChampionName(getChampionNameOfPosition($invocation, 'teammate','support'));
                $current[] = slipizeChampionName(getChampionNameOfPosition($invocation, 'ennemy','adc'));
                $current[] = slipizeChampionName(getChampionNameOfPosition($invocation, 'ennemy','support'));
            break;

            case 'support':
                $current[] = slipizeChampionName(getChampionNameOfPosition($invocation, 'teammate','adc'));
                $current[] = slipizeChampionName(getChampionNameOfPosition($invocation, 'ennemy','adc'));
                $current[] = slipizeChampionName(getChampionNameOfPosition($invocation, 'ennemy','support'));
            break;
        }

        $data[$positionDataName][$championName][] = $current;
    }
}

file_put_contents(__DIR__ . '/../data/slips.js', json_encode($data));