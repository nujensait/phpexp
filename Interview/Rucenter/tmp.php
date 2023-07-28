<?php

// temp tests
require_once("Mult.php");

// test multiplyByRandom
echo "\nTest multiplyByRandom:\n";
for($i=0; $i< 10; $i++) {
    echo multiplyByRandom($i) . "\n";
}

