<?php

/**
 * AvitoTech task #2: Frequent numbers
 * (not optimal solution, see optimal in freq_nums2.php)
 *
 * Дан массив целых чисел nums и целое число k.
 * Нужно написать функцию на PHP, которая вынимает из массива k наиболее часто встречающихся элементов.
 */

function topKFrequent222($nums, $k) {
    $freq = [];

    foreach ($nums as $num) {
        $freq[$num] = isset($freq[$num]) ? $freq[$num] + 1 : 1;
    }

    arsort($freq);

    $result = array_slice(array_keys($freq), 0, $k);

    return $result;
}

/**
 * Get frequent numbers
 * @param array $arr
 * @param int $limit
 * @return array
 */
function getMaxFreqNums(array $arr, int $limit): array
{
    $freqArr = [];

    foreach ($arr as $num) {
        if (isset($freqArr[$num])) {
            $freqArr[$num] += 1;
        } else {
            $freqArr[$num] = 1;
        }
    }

    arsort($freqArr);

    $res = array_slice(array_keys($freqArr), 0, $limit);

    return $res;
}

var_dump(getMaxFreqNums([1,1,1,2,2,3,3,3,3,3], 2));     // [3, 1]