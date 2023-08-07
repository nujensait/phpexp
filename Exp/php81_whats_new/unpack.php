<?php

// Распаковка массива с помощью строковых ключей
// PHP раньше поддерживал распаковку массивов с помощью оператора '...',
// но только если массивы были с целочисленными ключами.
// Теперь можно также распаковывать массивы со строковыми ключами.

$array = ["a" => 1];
$array2 = ["b" => 2];

$arrayMerge = ["a" => 0, ...$array, ...$array2];

var_dump($arrayMerge); // ["a" => 1, "b" => 2]