<?php

/**
 * Create a function that takes two numbers and checks
 * if the square root of the first number is equal to the cube root of the second number.
https://codebattle.hexlet.io/games/64569

Examples:

true   == solution(4, 8)
false  == solution(16, 48)
true   == solution(9, 27)
false  == solution(4, 27)
 */

/**
 * @param int $first
 * @param int $second
 * @return bool
 */
function solution(int $first, int $second)
{
    return ($first ** (1/2) === $second ** (1/3));
}