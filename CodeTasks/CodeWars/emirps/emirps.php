<?php

/**
 * @param $n
 * @return array
 */
function find_emirp($n)
{
    $emirps = [];
    $largest = 0;
    $sum = 0;

    for ($i = 2; $i < $n; $i++) {
        if (is_prime($i)) {
            $reverse = strrev($i);
            if ($reverse != $i && is_prime($reverse)) {
                $emirps[] = $i;
                $sum += $i;
                $largest = max($largest, $i);
            }
        }
    }

    return [count($emirps), $largest, $sum];
}

/**
 * @param $num
 * @return bool
 */
function is_prime($num)
{
    if ($num == 2) {
        return true;
    }

    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }

    return true;
}

echo "<br />\n";
var_dump(find_emirp(10));       // [0, 0, 0] ''' no emirps below 10 '''

echo "<br />\n";
var_dump(find_emirp(50));       // [4, 37, 98] ''' there are 4 emirps below 50: 13, 17, 31, 37; largest = 37; sum = 98 '''

echo "<br />\n";
var_dump(find_emirp(100));      // [8, 97, 418] ''' there are 8 emirps below 100: 13, 17, 31, 37, 71, 73, 79, 97; largest = 97; sum = 418 '''
