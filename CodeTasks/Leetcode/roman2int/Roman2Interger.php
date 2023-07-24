<?php

class Solution {

    const DIGITS = [
        'I' => 1,
        'V' => 5,
        'X' => 10,
        'L' => 50,
        'C' => 100,
        'D' => 500,
        'M' => 1000
    ];

    const DIGITS2 = [
        'IV' => 4,
        'IX' => 9,
        'XL' => 40,
        'XC' => 90,
        'CD' => 400,
        'CM' => 900
    ];

    /**
     * @param string $s
     * @return int
     * @throws Exception
     */
    function romanToInt(string $s): int
    {
        $sum = 0;
        $len = strlen($s);
        for($i = 0; $i < $len; $i++) {

            $chr = substr($s, $i, 2);
            $digit = self::DIGITS2[$chr] ?? null;
            if($digit) {
                $i++;
            } else {
                $chr = substr($s, $i, 1);
                $digit = self::DIGITS[$chr] ?? null;
                if(!$digit) {
                    throw new \Exception("Error: unkonown digit: " . $chr);
                }
            }

            $num = $digit;
            $sum += $num;
        }

        return $sum;
    }
}

$sol = new Solution();

echo "\n";
echo $sol->romanToInt("III");        // 3

echo "\n";
echo $sol->romanToInt("VI");        // 6

echo "\n";
echo $sol->romanToInt("IV");        // 4

echo "\n";
echo $sol->romanToInt("LVIII");        // 58

echo "\n";
echo $sol->romanToInt("MCMXCIV");        // 1994