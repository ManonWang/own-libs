<?php

$arr = array(11,-3,51,-7,9,100,2,-56,32,21);
$arr = quick_sort($arr);
print_r($arr);

function quick_sort($arr) {
	$count = count($arr);
	if ($count <= 1) {
		return $arr;
	}

	$left_arr  = array();
	$right_arr = array();

	for ($index = 1; $index < $count; $index ++) {
		if ($arr[0] >= $arr[$index]) {
			$left_arr[]  = $arr[$index];
		} else {
			$right_arr[] = $arr[$index];
		}
	}

	return array_merge(quick_sort($left_arr), array($arr[0]), quick_sort($right_arr));
}
