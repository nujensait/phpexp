## Task source 
https://www.codewars.com/kata/544aed4c4a30184e960010f4/train/php

## Title
7 kyu - Find the divisors!

## Task
Create a function named divisors/Divisors that takes an integer n > 1 
and returns an array with all of the integer's divisors
(except for 1 and the number itself), from smallest to largest. 
If the number is prime return the string '(integer) is prime'
(null in C#, empty table in COBOL) 
(use Either String a in Haskell and ``Result<Vec<u32>, String>`` in Rust).

### Example:
```
divisors(12);       // => [2, 3, 4, 6]
divisors(25);       // => [5]
divisors(13);       // => '13 is prime'
```

## Run
```
php divisors.php
```