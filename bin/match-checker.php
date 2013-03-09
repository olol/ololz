<?php

use Ololz\Entity;

require __DIR__ . '/../autoload_init.php';
\Zend\Loader\AutoloaderFactory::factory();
$application = \Zend\Mvc\Application::init(include 'config/application.config.php');

$summoners = array(

//    '19704654' // Avvoo

    '20650138', // Eowynia
    '21207110', // Kilemo
    '22042113', // Pirlouitus
    '22283677', // Reziek
    '91898',    // S0da
    '22289896', // Violpoul
    '22929106', // MBlackMamba
);

$stats = @include_once(__DIR__ . '/../data/stats.php');

/* @var $mappingService \Ololz\Service\Persist\Mapping */
$mappingService     = $application->getServiceManager()->get('Ololz\Service\Persist\Mapping');
/* @var $lolKingSource \Ololz\Entity\Source */
$lolKingSource      = $application->getServiceManager()->get('Ololz\Mapper\Source')->findOneByCode(Entity\Source::CODE_LOLKING);


function getUniqueHashOfMatch($game, $mappingService, $lolKingSource) {
    $string = '';

    // Sort all invocations with same order
    $invocations = array_merge($game['teammates'], $game['ennemies']);
    uksort($invocations, 'strcasecmp');
    foreach ($invocations as $summonerName => $invocation) {
        $champion = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_CHAMPION, Entity\Mapping::COLUMN_CODE, $invocation['champion']);
        if (! $champion) {
            throw new \Exception('Champion for ' . $invocation['champion'] . ' was not found in database');
        }
        $string .= $summonerName . $champion->getCode();
    }

    $matchType = $mappingService->getMapper()->findOneOurs($lolKingSource, Entity\Mapping::TYPE_MATCH_TYPE, Entity\Mapping::COLUMN_CODE, $game['type']);
    if (! $matchType) {
        throw new \Exception('Match type for ' . $game['type'] . ' was not found in database');
    }
    $string .= $matchType->getCode();
    $string .= $game['length'];
    $string .= $game['date'] instanceof \DateTime ? $game['date']->format('Y-m-d\TH:i:s') : strlen($game['date']) != 19 ? $game['date'] . 'T00:00' : str_replace(' ', 'T', substr($game['date'], 0, -3));

    $hash = hash('md5', $string);
    return $hash;
}

function array_merge_recursive_distinct(array &$array1, array &$array2) {
    $merged = $array1;

    foreach ($array2 as $key => &$value) {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            $merged[$key] = array_merge_recursive_distinct($merged[$key], $value);
        }
        else {
            $merged[$key] = $value;
        }
    }

    return $merged;
}

foreach ($summoners as $summonerLolKingId) {

    $html = file_get_contents('http://www.lolking.net/summoner/euw/' . $summonerLolKingId);

    $doc = phpQuery::newDocumentHTML($html);
    phpQuery::selectDocument($doc);

    $summoner = pq('.summoner_titlebar div:eq(1) div:eq(0)');
    $summonerName = $summoner->text();

    $history = pq('.tabs2_container .pane_inner:eq(3)');

    $stats['matches'] = array_key_exists('matches', $stats) ? $stats['matches'] : array();

    foreach ($history['> div'] as $match) {
        $match = pq($match);
        $game = array();

        // Teammates
        $game['teammates'] = array();
        foreach ($match['.match_details_extended table table:eq(0) tr'] as $keyTeammate => $teammate) {
            if ($keyTeammate == 0) {
                continue;
            }
            $teammate = pq($teammate);
            $teammateName = $teammate['td:eq(1)']->text();
            $game['teammates'][$teammate['td:eq(1)']->text()] = array(
                'champion' => str_replace('/champions/', '', $teammate['td:eq(0) a']->attr('href'))
            );
        }

        $summonerOfTheMatch = &$game['teammates'][$summonerName];

        // Ennemies
        $game['ennemies'] = array();
        foreach ($match['.match_details_extended table table:eq(1) tr'] as $keyEnnemy => $ennemy) {
            if ($keyEnnemy == 0) {
                continue;
            }
            $ennemy = pq($ennemy);
            $game['ennemies'][$ennemy['td:eq(1)']->text()] = array(
                'champion' => str_replace('/champions/', '', $ennemy['td:eq(0) a']->attr('href'))
            );
        }

        foreach ($match['.match_details_cell'] as $keyDetails => $details) {
            $details = pq($details);

            switch ($keyDetails)
            {
                case 0: // Champion
    //                $game['champion'] = str_replace('/champions/', '', pq($details['a'])->attr('href'));
                break;
                case 1: // Type
                    $game['type'] = $details['div div:eq(0)']->text();
                    $game['result'] = $details['div div:eq(1)']->text() == 'Loss' ? 'L' : 'V';
                    $game['date'] = new \DateTime($details['div div:eq(2) span']->attr('data-hoverswitch'));
                    $game['date'] = $game['date']->format('Y-m-d H:i:s');
                break;
                case 2: // Length
                    $game['length'] = (int) str_replace(' mins', '', $details['div strong']->text());
                break;
                case 3: // KDA
                    $summonerOfTheMatch['kills'] = (int) $details['strong:eq(0)']->text();
                    $summonerOfTheMatch['deaths'] = (int) $details['strong:eq(1)']->text();
                    $summonerOfTheMatch['assists'] = (int) $details['strong:eq(2)']->text();
                break;
                case 4: // Gold
                    $summonerOfTheMatch['gold'] = (float) $details['strong']->text();
                break;
                case 5: // Minions
                    $summonerOfTheMatch['minions'] = (int) $details['strong']->text();
                break;
                case 6: // Spells
                    $summonerOfTheMatch['spells'] = array();
                    $spell = $details['div.icon_36:eq(0)']->attr('style');
                    $summonerOfTheMatch['spells'][0] = substr($spell, strrpos($spell, '/') + 1, strrpos($spell, '.') - 1 - strrpos($spell, '/'));
                    $spell = $details['div.icon_36:eq(1)']->attr('style');
                    $summonerOfTheMatch['spells'][1] = substr($spell, strrpos($spell, '/') + 1, strrpos($spell, '.') - 1 - strrpos($spell, '/'));
                break;
                case 7: // Items
                    $summonerOfTheMatch['items'] = array();
                    foreach ($details['div.icon_32 a'] as $item) {
                        $item = pq($item);
                        $summonerOfTheMatch['items'][] = str_replace('/items/', '', $item->attr('href'));
                    }
                break;
            }
        }

        // Summoner personnal stats

        foreach ($match['.match_details_extended_stats td'] as $keyStats => $summonerStats) {
            $summonerStats = pq($summonerStats);

            switch ($keyStats)
            {
                case 0: // Damage dealt
                    $summonerOfTheMatch['damageDealt'] = (float) str_replace(',', '.', $summonerStats->text());
                break;
                case 1: // Damage received
                    $summonerOfTheMatch['damageReceived'] = (float) str_replace(',', '.', $summonerStats->text());
                break;
                case 2: // Healing done
                    $summonerOfTheMatch['healingDone'] = (float) str_replace(',', '.', $summonerStats->text());
                break;
                case 3: // Largest multi-kill
                    $summonerOfTheMatch['largestMultiKill'] = (int) $summonerStats->text();
                break;
                case 4: // Time spent dead
                    $summonerOfTheMatch['timeSpentDead'] = (int) $summonerStats->text();
                break;
                case 5: // Turrets destroyed
                    $summonerOfTheMatch['turretsDestroyed'] = (int) $summonerStats->text();
                break;
            }
        }
        $hash = getUniqueHashOfMatch($game, $mappingService, $lolKingSource);
        if (array_key_exists($hash, $stats['matches'])) {
            $game = array_merge_recursive_distinct($stats['matches'][$hash], $game);
        }
        $stats['matches'][$hash] = $game;
    }
}

uasort($stats['matches'], function($match1, $match2) {
    $date1 = array_key_exists('date', $match1) ? $match1['date'] : '9999-99-99 99:99:99';
    $date2 = array_key_exists('date', $match2) ? $match2['date'] : '9999-99-99 99:99:99';
    return strcmp($date1, $date2);
} );

file_put_contents(__DIR__ . '/../data/stats.php', '<?php return ' . var_export($stats, true) . ';');
file_put_contents(__DIR__ . '/../data/stats.js', json_encode($stats));
