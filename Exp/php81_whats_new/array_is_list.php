<?php

// Новая функция array_is_list
// Любой массив с ключами, не начинающимися с нуля,
// или любой массив, в котором не все ключи являются целыми числами в последовательном порядке,
// результат будет false:

$arrays = [
    ["a", "b", "c"],                        // T
    [1 => "a", 2 => "b", 3 => "c"],         // F
    ["a" => "a", "b" => "b", "c" => "c"],   // F
    [1 => 'apple', 'orange'],               // F - ключи начинаются не с 0
    [0 => 'apple', 'foo' => 'bar'],         // F - Не все числовые ключи
    [1 => 'apple', 0 => 'orange'],          // F - Ключи не отсортированы
    [0 => 'apple', 2 => 'bar'],             // F - Непоследовательные ключи
];

foreach($arrays as $arr) {
    var_dump($arr);
    $res = array_is_list($arr);
    echo ($res ? 'T' : 'F') . "\n\n";
}
