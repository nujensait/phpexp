<?php

/**
 * Class Solution
 * @source https://leetcode.com/problems/two-sum/
 * Given an array of integers nums and an integer target, return indices of the two numbers such that they add up to target.
 * You may assume that each input would have exactly one solution, and you may not use the same element twice.
 * You can return the answer in any order.
 *
 * Example 1:
 * Input: nums = [2,7,11,15], target = 9
 * Output: [0,1]
 * Output: Because nums[0] + nums[1] == 9, we return [0, 1].
 *
 * Example 2:
 * Input: nums = [3,2,4], target = 6
 * Output: [1,2]
 *
 */

class Solution
{
    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function twoSum($nums, $target)
    {
        if(!is_array($nums) || !count($nums)) {
            return [];
        }

        $len = count($nums);
        for($i = 0; $i < $len - 1; $i++) {
            for($j = $i + 1; $j < $len; $j++) {
                if($nums[$i] + $nums[$j] == $target) {
                    return [$i, $j];
                }
            }
        }

        return [];
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Example 1:
echo "\n\nExample 1\n";
$nums = [2, 7, 11, 15];
$target = 9;
$obj = new Solution();
$ret = $obj->twoSum($nums, $target);
echo var_export($ret, 1);
// [0, 1].

// Example 2:
echo "\n\nExample 2\n";
$nums = [3,2,4];
$target = 6;
$ret = $obj->twoSum($nums, $target);
echo var_export($ret, 1);
// Output: [1,2]

// Example 3:
echo "\n\nExample 3\n";
$nums = [3,3];
$target = 6;
$ret = $obj->twoSum($nums, $target);
echo var_export($ret, 1);
// Output: [0,1]

// MY TESTS

echo "\n\nExample 4\n";
$nums = [9];
$target = 9;
$ret = $obj->twoSum($nums, $target);
echo var_export($ret, 1);
// [] ?

echo "\n\nExample 4\n";
$nums = [];
$target = 9;
$ret = $obj->twoSum($nums, $target);
echo var_export($ret, 1);
// [] ?