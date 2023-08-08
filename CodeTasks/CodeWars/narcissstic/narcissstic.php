<?php

/**
 * @param int $value
 * @return float|int|object
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

/**
 * @param int $value
 * @return bool
 */
function narcissistic(int $value): bool {
    return $value == make_narcissistic($value);
}

// TESTS

var_dump(make_narcissistic(153));
var_dump(make_narcissistic(1938));
var_dump(make_narcissistic(7));
var_dump(make_narcissistic(371));

