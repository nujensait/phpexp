<?php

/**
 * @param int $first
 * @param int $second
 * @return bool
 */
function solution(int $first, int $second)
{
    return ($first ** (1/2) === $second ** (1/3));
}