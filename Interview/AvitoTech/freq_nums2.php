<?php

/**
 * AvitoTech task #2: Frequent numbers
 * (optimized solution)
 *
 * Дан массив целых чисел nums и целое число k.
 * Нужно написать функцию на PHP, которая вынимает из массива k наиболее часто встречающихся элементов.
 */

/**
 * Get frequent numbers
 * @param array $freqs
 * @param int $limit
 * @return array
 */
function getMaxFreqNums(array $freqs, int $limit): array
{
    $freqArr = [];

    if(!is_array($freqs) || !count($freqs)) {
        return [];
    }

    // [num => frequence]
    foreach ($freqs as $num) {
        if (isset($freqArr[$num])) {                // [1 => 3, 2 => 2, 3 => 4, 4 => 4, 1 => 5]
            $freqArr[$num] += 1;
        } else {
            $freqArr[$num] = 1;
        }
    }

    // [frequence => <nums_array>]
    $tmpArr = [];
    foreach ($freqArr as $num => $freq) {
        $tmpArr[$freq][] = $num;                    // [1 => [5], 2 => [2], 3 => [1], 4 => [3, 4]]
    }

    $freqArr = $tmpArr;

    // count result as slice of $maxArr
    $res = [];

    $freqArrKeys = array_keys($freqArr);
    $maxKey = max($freqArrKeys);

    for ($i = $maxKey; $i >= 0; $i--) {
        $freqs = (isset($freqArr[$i]) ? $freqArr[$i] : []);
        foreach ($freqs as $elem) {
            $res[] = $elem;
            if (count($res) >= $limit) {
                return $res;
            }
        }
    }

    return $res;
}

////////////////////////////////////

echo "\n";
var_dump(getMaxFreqNums([], 2));     // []

echo "\n";
var_dump(getMaxFreqNums([1], 1));     // [1]

echo "\n";
var_dump(getMaxFreqNums([1,1,1,2,2,3,3,3,3,3,3,4,4,4,4,4,5], 2));     // [3, 4]

