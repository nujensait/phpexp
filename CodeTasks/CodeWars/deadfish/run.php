<?php

// DeadFish task

/**
 * @param string $code
 * @return array
 */
function parse(string $code): array
{
    $value = 0;
    $output = [];

    for ($i = 0; $i < strlen($code); $i++) {
        $cmd = $code[$i];

        if ($cmd == 'i') {
            $value++;
        } else if ($cmd == 'd') {
            $value--;
        } else if ($cmd == 's') {
            $value = pow($value, 2);
        } else if ($cmd == 'o') {
            $output[] = $value;
        }
    }

    return $output;
}

print_r(parse("iiisdoso")); // [8, 64]