<?php

/**
 * Программа для вычисления ранга матрицы из вещественных чисел
 */

/**
 * Интерфейс для скалярных операцийнад матрицами
 */
interface iScalarMatrixOperation
{
    public function init(array $matrix): void;
    public function calc(): float;
}

/**
 * Операцуия по вычсилению ранга матрицы
 */
class MatrixRankOperation implements iScalarMatrixOperation
{
    private array $matrix;
    private int $rowsCnt;
    private int $columnsCnt;

    /**
     * Инициализация
     * @param array $matrix
     * @return void
     */
    public function init(array $matrix): void {
        $this->matrix = $matrix;
        // Получаем количество строк и столбцов матрицы
        $rows = count($this->matrix);
        $columns = count($this->matrix[0]);
    }

    /**
     * Вычисляем ранг матрицы
     *
     * Рангом системы строк (столбцов) матрицы A с M строками и N столбцами называется максимальное число линейно независимых строк (столбцов).
     * Несколько строк (столбцов) называются линейно независимыми, если ни одна из них не выражается линейно через другие.
     * Ранг системы строк всегда равен рангу системы столбцов, и это число называется рангом матрицы.
     *
     * @return float
     */
    public function calc(): float
    {
        // Создаем массив для хранения уникальных элементов
        $uniqueElements = array();

        // Проходим по всем элементам матрицы и добавляем уникальные элементы в массив
        for ($i = 0; $i < $this->rowsCnt; $i++) {
            for ($j = 0; $j < $this->columnsCnt; $j++) {
                if (!in_array($this->matrix[$i][$j], $uniqueElements)) {
                    $uniqueElements[] = $this->matrix[$i][$j];
                }
            }
        }

        // Сортируем массив уникальных элементов по возрастанию
        sort($uniqueElements);

        // Вычисляем ранг матрицы
        $rank = $this->columnsCnt;

        for ($i = 0; $i < $this->rowsCnt; $i++) {
            $rowElements = array();
            for ($j = 0; $j < $this->columnsCnt; $j++) {
                if (!in_array($this->matrix[$i][$j], $rowElements)) {
                    $rowElements[] = $this->matrix[$i][$j];
                }
            }
            $rowUniqueCount = count($rowElements);
            if ($rowUniqueCount < $this->columnsCnt) {
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
