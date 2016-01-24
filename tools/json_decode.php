<?php

$handle = fopen("php://stdin", 'r');
while (!feof($handle)) {
    $line = trim(fgets($handle));
    print_r(json_decode($line, true));
}
