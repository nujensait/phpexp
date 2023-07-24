<?php

/**
 * "Emirps" task by CodeWars
 * @source https://www.codewars.com/kata/55de8eabd9bef5205e0000ba/train/php
 * (*) version #2, works for long N values
 */

class Emirp
{
    private static $primes = [];

    private static $start = 2;

    /**
     * @param $n
     * @return array
     */
    public static function findEmirp(int $n): array
    {
        self::genPrimes($n);

        $emirps = [];
        $largest = 0;
        $sum = 0;

        foreach(self::$primes as $prime) {
            if($prime > $n) {
                break;
            }
            $reverse = strrev($prime);
            if ($reverse != $prime && isset(self::$primes[$reverse])) {
                $emirps[] = $prime;
                $sum += $prime;
                $largest = max($largest, $prime);
            }
        }

        return [count($emirps), $largest, $sum];
    }

    /**
     * @param $num
     * @return bool
     */
    private static function isPrime($num)
    {
        if ($num == 2) {
            return true;
        }

        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i == 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int $n
     * @return void
     */
    private static function genPrimes(int $n)
    {
        for ($i = self::$start; $i < $n; $i++) {
            if (self::isPrime($i)) {
                self::$primes[(int)$i] = (int)$i;
            }
            $rev = strrev($i);
            if (self::isPrime($rev)) {
                self::$primes[(int)$rev] = (int)$rev;
            }
        }
        asort(self::$primes);

        self::$start = $i;  // remember last calulated iteration
    }
}

/**
 * @param int $n
 * @return int
 */
function find_emirp(int $n): array
{
    $sol = new Emirp();
    return $sol->findEmirp($n);
}

echo "<br />\n";
var_dump(find_emirp(10));       // [0, 0, 0] ''' no emirps below 10 '''

echo "<br />\n";
var_dump(find_emirp(50));       // [4, 37, 98] ''' there are 4 emirps below 50: 13, 17, 31, 37; largest = 37; sum = 98 '''

echo "<br />\n";
var_dump(find_emirp(100));      // [8, 97, 418] ''' there are 8 emirps below 100: 13, 17, 31, 37, 71, 73, 79, 97; largest = 97; sum = 418 '''
