<?php

/**
 * @param int $n
 * @return array|string
 */
function divisors(int $n): array|string
{
    $ret = [];
    for ($i = 2; $i < $n; $i++) {
        if ($n % $i == 0) {
            $ret[] = $i;
        }
    }
    if (!count($ret)) {
        return "{$n} is prime";
    }
    return $ret;
}