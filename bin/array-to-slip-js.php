<?php

/**

suppKilemo = {
  'Sona': [
      {'stats': [3,8,16,8.6,75]},
      {'items': [3006,1055,3124,3146]},
      {'details': [59,23,7,1,229,2]},
      {'team': [{'Azenor':'caitlyn'},{'Azenor':'caitlyn'},{'Azenor':'caitlyn'},{'Azenor':'caitlyn'}]},
      {'ennemies': [{'Azenor':'caitlyn'},{'Azenor':'caitlyn'},{'Azenor':'caitlyn'},{'Azenor':'caitlyn'},{'Azenor':'caitlyn'}]},
      {'info': ['V','2013-02-26',37]},
    ],
}

 */

$summoners = $slips = array(
//    'Eowynia'       => array(),
    'Kilemo'        => array(),
    'Pirlouitus'    => array(),
    'Reziek'        => array(),
    'S0da'          => array(),
    'Violpoul'      => array(),
//    'MBlackMamba'   => array()
);

include_once(__DIR__ . '/../data/stats.php');

foreach ($stats['matches'] as &$match) {

    foreach ($summoners as $summonerName => $null) {

        if (
            array_key_exists($summonerName, $match['teammates']) &&
            array_key_exists('kills', $match['teammates'][$summonerName])
        ) {

            $invocation = &$match['teammates'][$summonerName];
            $champion = $invocation['champion'];

            if (! array_key_exists($champion, $slips[$summonerName])) {
                $slips[$summonerName][$champion] = array();
            }

            $entry = array(
                'stats'     => array(
                    $invocation['kills'],
                    $invocation['deaths'],
                    $invocation['assists'],
                    $invocation['gold'],
                    $invocation['minions']
                ),
                'items'     => $invocation['items'],
                'details'   => array(
                    $invocation['damageDealt'],
                    $invocation['damageReceived'],
                    $invocation['healingDone'],
                    $invocation['largestMultiKill'],
                    $invocation['timeSpentDead'],
                    $invocation['turretsDestroyed']
                ),
                'info'      => array(
                    $match['result'],
                    $match['date'],
                    $match['length']
                ),
                'teammates' => array(),
                'ennemies'  => array()
            );

            foreach ($match['teammates'] as $teammateName => $teammate) {
                $entry['teammates'][] = array($teammateName => $teammate['champion']);
            }

            foreach ($match['ennemies'] as $ennemyName => $ennemy) {
                $entry['ennemies'][] = array($ennemyName => $ennemy['champion']);
            }

            $slips[$summonerName][$champion][] = $entry;
        }
    }
}

file_put_contents(__DIR__ . '/../data/slips.php', '<?php '.var_export($slips, true).';');

file_put_contents(__DIR__ . '/../data/slips.js', json_encode($slips));
