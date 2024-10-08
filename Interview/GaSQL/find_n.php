<?php

function processString($input) {
    // Выполнение программы редактора
    while (strpos($input, '52') !== false || strpos($input, '2222') !== false || strpos($input, '1122') !== false) {
        if (strpos($input, '52') !== false) {
            // Замена "52" на "11"
            $input = preg_replace('/52/', '11', $input, 1);
        } elseif (strpos($input, '2222') !== false) {
            // Замена "2222" на "5"
            $input = preg_replace('/2222/', '5', $input, 1);
        } elseif (strpos($input, '1122') !== false) {
            // Замена "1122" на "25"
            $input = preg_replace('/1122/', '25', $input, 1);
        }
    }

    return $input;
}

function sumOfDigits($input) {
    // Суммируем все цифры в строке
    $sum = 0;
    for ($i = 0; $i < strlen($input); $i++) {
        $sum += intval($input[$i]);
    }
    return $sum;
}

$maxN = 0; // Для хранения максимального значения n
for ($n = 4; $n < 10000; $n++) {
    // Начальная строка: "5" + n, состоящая из цифры "2"
    $input = '5' . str_repeat('2', $n);

    // Применяем программу редактора
    $result = processString($input);

    // Проверяем сумму цифр
    if (sumOfDigits($result) == 64) {
        $maxN = $n;
        // Найдено значение n с суммой цифр 64
        echo "Найдено значение n: $n с суммой цифр 64\n";
    }
}

echo "Максимальное значение n: $maxN\n";
