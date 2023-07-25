<?php

/**
 * AvitoTech task #1: arrays sum
 *
 * Мы хотим складывать очень большие числа, которые превышают емкость базовых типов,
 * поэтому мы храним их в виде массива неотрицательных чисел.
 *
 * Нужно написать функцию, которая примет на вход два таких массива, вычислит сумму чисел,
 * представленных массивами, и вернет результат в виде такого же массива.
 */

/**
 * Calc arrays sum
 * @param array $a
 * @param array $b
 * @return array
 */
function calcSum(array $a, array $b): array
{
    $res = [];
    $ost = 0;
    while (count($a) > 0 || count($b) > 0) {
        if (count($a)) {
            $digitA = array_pop($a);
        } else {
            $digitA = 0;
        }

        if (count($b)) {
            $digitB = array_pop($b);
        } else {
            $digitB = 0;
        }

        $sum = $digitA + $digitB + $ost;
        $digit = $sum % 10;
        $res[] = $digit;
        $ost = floor($sum / 10);
    }

    if ($ost > 0) {
        $res[] = $ost;
    }

    $res = array_reverse($res);     // 71 ==> 17

    return $res;
}

/////////////////////////////////////////

$a = [1];     # число 1
$b = [2];     # число 2
$res = calcSum($a, $b);
var_dump($res);     // [3] # число 3

echo "\n";

$a = [1, 2, 3];     # число 123
$b = [4, 5, 6];     # число 456
$res = calcSum($a, $b);
var_dump($res);     // [5, 7, 9] # число 579 (допустим ответ с первым незначимым нулем [0, 5, 7, 9])

echo "\n";

$a = [2, 9, 2, 3];     # число 2923
$b = [7, 5, 6];     # число 756
$res = calcSum($a, $b);
var_dump($res);     // [3, 6, 7, 9] # число 3679
