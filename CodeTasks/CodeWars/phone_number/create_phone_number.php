<?php

/**
 * @param $numbersArray
 * @return string
 */
function createPhoneNumber($numbersArray) {
    list($a, $b, $c, $d, $e, $f, $g, $h, $i, $j) = $numbersArray;
    return "($a$b$c) $d$e$f-$g$h$i$j";
}

// TEST (OK):

echo createPhoneNumber([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]);       // '(123) 456-7890'
echo "\n";
echo createPhoneNumber([1, 1, 1, 1, 1, 1, 1, 1, 1, 1]);       // '(111) 111-1111'

//////////////////////////////////////////////////////////////////////////
// Others solutions:

/**
 * @param array $digits
 * @return string
 */
function createPhoneNumber2(array $digits): string {
    return sprintf("(%d%d%d) %d%d%d-%d%d%d%d", ...$digits);
}

/**
 * @param $numbersArray
 * @return string
 */
function createPhoneNumber3($numbersArray) {
    return vsprintf("(%d%d%d) %d%d%d-%d%d%d%d", $numbersArray);
}