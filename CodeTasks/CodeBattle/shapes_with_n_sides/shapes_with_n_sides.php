<?php

/**
 * @param int $sides
 * @return string
 */
function solution(int $sides)
{
    $arr = [
        "circle" ,
        "semi-circle",
        "triangle" ,
        "square"  ,
        "pentagon" ,
        "hexagon"  ,
        "heptagon" ,
        "octagon"  ,
        "nonagon"  ,
        "decagon"
    ];

    return $arr[$sides - 1];
}