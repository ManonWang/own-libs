<?php

$baiwei = array_unique(str_split($argv[1]));
$shiwei = array_unique(str_split($argv[2]));
$gewei  = array_unique(str_split($argv[3]));

$res = array();

foreach ($baiwei as $b) {
    foreach ($shiwei as $s) {
        foreach ($gewei as $g) {
            $num = array($b, $s, $g);
            $cnt = count(array_unique($num));
            $num = implode($num, '');
            $res[$cnt][$num] = $num;
        }
    }
}



echo implode($res[3], ' ') . PHP_EOL . PHP_EOL;
echo implode($res[2], ' ') . PHP_EOL . PHP_EOL;
echo implode($res[1], ' ') . PHP_EOL . PHP_EOL;
