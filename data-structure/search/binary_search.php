<?php

	function binary_search($arr, $val) {
		$low = 0;
		$hight = count($arr) - 1;

		while ($low <= $hight) {
			$middle = floor(($low + $hight) / 2);
			if ($arr[$middle] == $val) {
				return $val;
			} elseif ($arr[$middle] > $val) {
				$hight = $middle - 1 ;
			} else {
				$low = $middle + 1;
			}
		}

		return false;
	}

	$data = array(1,2,3,4,5,6,6,7,8,10,13,16,50);
	var_dump(binary_search($data,6));
	var_dump(binary_search($data,10));
	var_dump(binary_search($data,20));

