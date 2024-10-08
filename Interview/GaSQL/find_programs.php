<?php

function countPrograms($n, $target, &$memo) {
    // Если число больше целевого, то пути нет
    if ($n > $target) return 0;
    // Если мы достигли целевого значения, то это один путь
    if ($n == $target) return 1;
    // Если уже посчитали количество программ для данного числа, вернем результат
    if (isset($memo[$n])) return $memo[$n];
    // Если на пути встретили число 11, то оно запрещено
    if ($n == 11) return 0;

    // Считаем количество программ
    $result = 0;
    // Команда A: прибавить 1
    $result += countPrograms($n + 1, $target, $memo);
    // Команда B: умножить на 2, если n * 2 <= target
    if ($n * 2 <= $target) {
        $result += countPrograms($n * 2, $target, $memo);
    }
    // Команда C: возвести в квадрат, если n^2 <= target
    if ($n * $n <= $target) {
        $result += countPrograms($n * $n, $target, $memo);
    }

    // Запоминаем результат для данного числа
    $memo[$n] = $result;
    return $result;
}

// Начальные условия
$start = 2;
$target = 20;
$memo = [];
// Вычисляем количество программ
echo "Количество программ: " . countPrograms($start, $target, $memo) . "\n";

