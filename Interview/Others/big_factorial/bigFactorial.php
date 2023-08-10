<?php

// Напишите ф-ю вычисления факториала на php.
// Как ее поправить для вычисления факториалов больших чисел?

// Write factorial load function in php.
// How to fix it for a large number of factorials?

function factorial($n) {
    if ($n == 0) {
        return 1;
    } else {
        return $n * factorial($n-1);
    }
}

// пример использования
echo factorial(5); // выведет 120

// Для больших аргументов факториала можно использовать библиотеку BCMath в PHP:

function factorialBig($n) {
    if ($n == 0) {
        return 1;
    } else {
        $result = '1';
        for ($i = 1; $i <= $n; $i++) {
            $result = bcmul($result, $i);
        }
        return $result;
    }
}

// пример использования
echo "\n\n";
echo factorialBig(150); // выведет 5.71338395644585459047893286532948563933762624517425322315475808727100437566494598405124711143398519680000000000000000000000000