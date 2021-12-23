<?php

/**
 * @source https://www.codewars.com/kata/5287e858c6b5a9678200083c/train/php
 * SOLVED
 * Others soluions (mine is big): https://www.codewars.com/kata/5287e858c6b5a9678200083c/solutions/php
 */

/**
A Narcissistic Number is a positive number which is the sum of its own digits,
each raised to the power of the number of digits in a given base.
In this Kata, we will restrict ourselves to decimal (base 10).

For example, take 153 (3 digits), which is narcisstic:

1^3 + 5^3 + 3^3 = 1 + 125 + 27 = 153
and 1652 (4 digits), which isn't:

1^4 + 6^4 + 5^4 + 2^4 = 1 + 1296 + 625 + 16 = 1938
The Challenge:

Your code must return true or false depending upon whether the given number
is a Narcissistic number in base 10.

Error checking for text strings or other invalid inputs is not required,
only valid positive non-zero integers will be passed into the function.
 */

function make_narcissistic(int $value)
{
    $ret = 0;
    $str = strval($value);

    $pow = strlen($str);

    if($pow) {
        for($k = 0; $k < strlen($str); $k++) {
            $v = intval($str[$k]);
            $ret += pow($v, $pow);
        }
    }

    return $ret;
}

function narcissistic(int $value): bool {
    return $value == make_narcissistic($value);
}

var_dump(make_narcissistic(153));

var_dump(make_narcissistic(1938));

var_dump(make_narcissistic(7));

var_dump(make_narcissistic(371));

