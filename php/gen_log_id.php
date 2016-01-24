<?php


echo sprintf('%x', (intval(microtime(true) * 10000) % 864000000) * 10000 + mt_rand(100000, 999999) + getmypid());
