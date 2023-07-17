<?php

/**
 * Программа для вычисления ранга матрицы из вещественных чисел
 *
 * Рангом системы строк (столбцов) матрицы A с M строками и N столбцами называется максимальное число линейно независимых строк (столбцов).
 * Несколько строк (столбцов) называются линейно независимыми, если ни одна из них не выражается линейно через другие.
 * Ранг системы строк всегда равен рангу системы столбцов, и это число называется рангом матрицы.
 *
 * Пример запуска:
 * php MatrixRankOperation.php
 */

/**
 * Операция по вычислению ранга матрицы
 */
class MatrixRankOperation
{
    private array $matrix;
    private int $rowsCnt;
    private int $columnsCnt;

    /**
     * Инициализация
     * @param array $matrix
     * @return void
     */
    public function init(array $matrix): void
    {
        $this->matrix = $matrix;
        // Получаем количество строк и столбцов матрицы
        $this->rowsCnt = count($this->matrix);
        $this->columnsCnt = count($this->matrix[0]);
    }

    /**
     * Функция замены двух строк матрицы
     * @param $row1
     * @param $row2
     * @param $col
     * @return void
     */
    private function swap($row1, $row2, $col)
    {
        for ($i = 0; $i < $col; $i++) {
            $temp = $this->matrix[$row1][$i];
            $this->matrix[$row1][$i] = $this->matrix[$row2][$i];
            $this->matrix[$row2][$i] = $temp;
        }
    }

    /**
     * Вычисляем ранг матрицы
     * @return int
     */
    public function calc(): int
    {
        $rank = $this->columnsCnt;
        $row = 0;

        while($row < $rank) {
            // Прежде чем мы посетим текущую строку 'row',
            // мы убеждаемся, что matrix[row][0],....matrix[row][row-1] = 0

            // Диагональный элемент не равен нулю
            if ($this->matrix[$row][$row]) {
                $col = 0;
                while($col < $this->rowsCnt) {
                    if ($col != $row) {
                        // Обноуляем все элементы в текущем столбце, кроме 'matrix[row][row]'
                        $mult = $this->matrix[$col][$row] / $this->matrix[$row][$row];
                        for ($i = 0; $i < $rank; $i++) {
                            $this->matrix[$col][$i] -= $mult * $this->matrix[$row][$i];
                        }
                    }
                    $col++;
                }
            }
            // Диагональный элемент уже равен нулю.
            // Возникает два варианта:
            // 1) Если под ней есть строка с ненулевым элементами,
            // поменять местами эту строку с той строкой
            // и обрабатываем эту строку
            // 2) Если все элементы в текущем столбце ниже
            // matrix[r][row] равны 0, удаляем этот столбец,
            // поменяв местами его с последним столбцом и
            // уменьшенив количество столбцов на 1.
            else
            {
                $doReduce = true;

                /* Ищем ненулевой элемент в текущем столбце */
                $i = $row + 1;
                while($i < $this->rowsCnt) {
                    // Меняем местами строку с ненулевым элементом с этой строкой
                    if ($this->matrix[$i][$row]) {
                        $this->swap($row, $i, $rank);
                        $doReduce = false;
                        break;
                    }
                    $i++;
                }

                // Если мы не нашли ни одной строки с ненулевым элементом в текущем столбце,
                // то все значения в этом столбце равны 0.
                if ($doReduce) {
                    // Уменьшаем количество столбцов
                    $rank--;

                    // Копируем последний столбец сюда
                    $i = 0;
                    while ($i < $this->rowsCnt) {
                        $this->matrix[$i][$row] = $this->matrix[$i][$rank];
                        $i++;
                    }
                }

                // Заново обрабатываем текущую строку
                $row--;
            }

            $row++;
        }

        return $rank;
    }
}

///////////////////////////////////////////////////////
// Определяем матрицу
// (*) Проверить решения можно тут: https://matrix.reshish.ru/rankCalculation.php

// rank = 3 (верно)
$matrix = [
    [ 10.3,   20.6,  10.56],
    [-20.4,  -30.7,   10.4],
    [ 30.5,   50.8,      0]
];

$rankOp = new MatrixRankOperation();
$rankOp->init($matrix);
$rank = $rankOp->calc();

echo "Ранг матрицы: " . $rank . "\n";
