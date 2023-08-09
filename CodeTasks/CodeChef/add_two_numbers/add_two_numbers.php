<?php

$stdin = fopen('php://stdin', 'r');

while($line = trim(fgets(STDIN))) {
    $nums = explode(" ", $line);
    if(count($nums) == 2) {
        echo array_sum($nums) . "\n";
    } else {
        echo "\n";
    }
}

