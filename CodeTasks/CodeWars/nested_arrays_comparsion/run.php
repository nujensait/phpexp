<?php

/**
 * @param array $arr1
 * @param array $arr2
 * @return bool
 */
function same_structure_as(array $arr1, array $arr2): bool
{
    for ($i = 0 , $j = 0; $i < count($arr1) || $j < count($arr2); $i++, $j++) {
        $val1 = isset($arr1[$i]) ? $arr1[$i] : null;
        $val2 = isset($arr2[$j]) ? $arr2[$j] : null;

        //var_dump($val1); echo ' <==> '; var_dump($val2); echo "\n\n";

        if(gettype($val1) !== gettype($val2)) {
            return false;
        }
        if ($val1 === null || $val2 === null) {
            return false;
        }
        if (is_array($val1) && is_array($val2)) {
            return same_structure_as($val1, $val2);
        }
    }

    return true;
}

// TESTS
//var_dump(same_structure_as([1, 1, 1], [2, 2, 2]));      // => true
//var_dump(same_structure_as([], []));                    // => true
//var_dump(same_structure_as([1], [2, 3]));               // => false
//var_dump(same_structure_as([1, []], [2, []]));          // => true
//var_dump(same_structure_as([1, [1, 1]], [[2, 2], 2]));  // => false
