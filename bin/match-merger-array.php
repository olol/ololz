<?php
if ($argc != 3) {
    throw new \InvalidArgumentException('This script requires the path to both files to merge, relatively to the current working directory.');
}

$filePath1 = getcwd() . '/' . $argv[1];
if (! is_file($filePath1)) {
    throw new \InvalidArgumentException($filePath1 . ' is not a file');
}

$filePath2 = getcwd() . '/' . $argv[2];
if (! is_file($filePath2)) {
    throw new \InvalidArgumentException($filePath2 . ' is not a file');
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

$stats1 = require_once($filePath1);

$stats2 = require_once($filePath2);

foreach ($stats1['matches'] as $key1 => $match1) {
    if (array_key_exists($key1, $stats2['matches'])) {
        $stats1['matches'][$key1] = array_merge_recursive_distinct($stats1['matches'][$key1], $stats2['matches'][$key1]);
    }
}

foreach ($stats2['matches'] as $key2 => $match2) {
    if (! array_key_exists($key2, $stats1['matches'])) {
        $stats1['matches'][$key2] = $stats2['matches'][$key2];
    }
}

usort($stats1['matches'], function($match1, $match2) {
    $date1 = array_key_exists('date', $match1) ? $match1['date'] : '9999-99-99 99:99:99';
    $date2 = array_key_exists('date', $match2) ? $match2['date'] : '9999-99-99 99:99:99';
    return strcmp($date1, $date2);
} );

file_put_contents($filePath1 . '.merged.php', '<?php return ' . var_export($stats1, true) . ';');
