<?php

/**
 * Task: shapes_with_n_sides
https://codebattle.hexlet.io/games/64570

 * Create a function that takes a whole number as input and returns the shape with that number's amount of sides. Check examples below.

Examples:
"circle"  == solution(1)
"semi-circle"  == solution(2)
"triangle"  == solution(3)
"square"  == solution(4)
"pentagon"  == solution(5)
"hexagon"  == solution(6)
"heptagon"  == solution(7)
"octagon"  == solution(8)
"nonagon"  == solution(9)
"decagon"  == solution(10)
 */

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