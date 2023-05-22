<?php

/**
 * Напиши программу на языке php для вычисления ранга матрицы из вещественных чисел.
 */

// Определяем матрицу
$matrix = array(
    array(1, 2, 3),
    array(4, 5, 6),
    array(7, 8, 9)
);

// Получаем количество строк и столбцов матрицы
$rows = count($matrix);
$columns = count($matrix[0]);

// Создаем массив для хранения уникальных элементов
$uniqueElements = array();

// Проходим по всем элементам матрицы и добавляем уникальные элементы в массив
for ($i = 0; $i < $rows; $i++) {
    for ($j = 0; $j < $columns; $j++) {
        if (!in_array($matrix[$i][$j], $uniqueElements)) {
            $uniqueElements[] = $matrix[$i][$j];
        }
    }
}

// Сортируем массив уникальных элементов по возрастанию
sort($uniqueElements);

// Получаем количество уникальных элементов
$uniqueCount = count($uniqueElements);

// Вычисляем ранг матрицы
$rank = $columns;

for ($i = 0; $i < $rows; $i++) {
    $rowElements = array();
    for ($j = 0; $j < $columns; $j++) {
        if (!in_array($matrix[$i][$j], $rowElements)) {
            $rowElements[] = $matrix[$i][$j];
        }
    }
    $rowUniqueCount = count($rowElements);
    if ($rowUniqueCount < $columns) {
        $rank--;
    }
}

echo "Ранг матрицы: " . $rank;

?>