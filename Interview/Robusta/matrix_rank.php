<?php

/**
 * Программа для вычисления ранга матрицы из вещественных чисел
 */

interface iScalarMatrixOperation
{
    public function init(array $matrix): void;
    public function calc(): float;
}

class MatrixRankOperation implements iScalarMatrixOperation
{
    private array $matrix;

    public function init(array $matrix): void {
        $this->matrix = $matrix;
    }

    /**
     * Рангом системы строк (столбцов) матрицы A с m строками и n столбцами называется максимальное число линейно независимых строк (столбцов).
     * Несколько строк (столбцов) называются линейно независимыми, если ни одна из них не выражается линейно через другие.
     * Ранг системы строк всегда равен рангу системы столбцов, и это число называется рангом матрицы.
     * @return void
     */
    public function calc(): float
    {
        // Получаем количество строк и столбцов матрицы
        $rows = count($this->matrix);
        $columns = count($this->matrix[0]);

        // Создаем массив для хранения уникальных элементов
        $uniqueElements = array();

        // Проходим по всем элементам матрицы и добавляем уникальные элементы в массив
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                if (!in_array($this->matrix[$i][$j], $uniqueElements)) {
                    $uniqueElements[] = $this->matrix[$i][$j];
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
                if (!in_array($this->matrix[$i][$j], $rowElements)) {
                    $rowElements[] = $this->matrix[$i][$j];
                }
            }
            $rowUniqueCount = count($rowElements);
            if ($rowUniqueCount < $columns) {
                $rank--;
            }
        }

        return $rank;
    }
}

///////////////////////////////////////////////////////

// Определяем матрицу
$matrix = array(
    array(1, 2, 3),
    array(4, 5, 6),
    array(7, 8, 9)
);

$rankOp = new MatrixRankOperation();
$rankOp->init($matrix);
$rank = $rankOp->calc();

echo "Ранг матрицы: " . $rank;
