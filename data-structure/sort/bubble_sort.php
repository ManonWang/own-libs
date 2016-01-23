<?php

$arr = array(11,-3,51,-7,9,100,2,-56,32,21);


$flag = false;
$times = count($arr) - 1;
for ($time = 0; $time < $times; $time ++) {
	for($index = 0; $index < $times - $time; $index ++) {
		if ($arr[$index] > $arr[$index + 1]) {
			$temp = $arr[$index];
			$arr[$index] = $arr[$index + 1];
			$arr[$index + 1] = $temp;
			$flag = true;
		}
	}

	if (!$flag) {
		break;
	} else {
		$flag = false;
	}
}


print_r($arr);
