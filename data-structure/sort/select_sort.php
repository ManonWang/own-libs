<?php

$arr = array(11,-3,51,-7,9,100,2,-56,32,21);

$times = count($arr) - 1;
for ($time = 0; $time < $times; $time ++) {
	$min = $time;
	for ($index = $time + 1; $index <= $times; $index ++) {
		if ($arr[$index] < $arr[$min]) {
			$min = $index;
		}
	}

	$temp = $arr[$time];
	$arr[$time] = $arr[$min];
	$arr[$min]  = $temp;
}

print_r($arr);
