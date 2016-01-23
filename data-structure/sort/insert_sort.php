<?php

$arr = array(11,-3,51,-7,9,100,2,-56,32,21);

$times = count($arr) - 1;
for ($time = 1; $time <= $times; $time ++) {
  $index = $time - 1;
  $value = $arr[$time];
  while ($index >= 0 && $value < $arr[$index]) {
  	 $arr[$index + 1] = $arr[$index];
	 $index -- ;
  }
  $arr[$index + 1] = $value;
}

print_r($arr);
