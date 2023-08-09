<?php

$stdin = fopen('php://stdin', 'r');

fscanf(STDIN, "%d %d\n", $n, $k);

$cnt = $i = 0;

while($line = trim(fgets(STDIN))) {
    $num = intval($line);
    if($num % $k == 0) {
        $cnt++;
    }
    $i++;
    if($i > $n) {
        break;
    }
}

echo $cnt . "\n";

