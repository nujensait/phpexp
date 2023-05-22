<?php

/**
 * Программа для вычисления ранга матрицы из вещественных чисел
 * Рангом системы строк (столбцов) матрицы A с M строками и N столбцами называется максимальное число линейно независимых строк (столбцов).
 * Несколько строк (столбцов) называются линейно независимыми, если ни одна из них не выражается линейно через другие.
 * Ранг системы строк всегда равен рангу системы столбцов, и это число называется рангом матрицы.
 */

/**
 * Интерфейс для скалярных операций над матрицами
 */
interface iScalarMatrixOperation
{
    public function init(array $matrix): void;

    public function calc(): float;
}

/**
 * Операция по вычислению ранга матрицы
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
     * @return float
     */
    public function calc(): float
    {
        $rank = $this->columnsCnt;

        for ($row = 0; $row < $rank; $row++) {
            // Прежде чем мы посетим текущую строку 'row',
            // мы убеждаемся, что matrix[row][0],....matrix[row][row-1] = 0

            // Диагональный элемент не равен нулю
            if ($this->matrix[$row][$row]) {
                for ($col = 0; $col < $this->rowsCnt; $col++) {
                    if ($col != $row) {
                        // This makes all entries of current
                        // column as 0 except entry 'matrix[row][row]'
                        $mult = $this->matrix[$col][$row] / $this->matrix[$row][$row];
                        for ($i = 0; $i < $rank; $i++) {
                            $this->matrix[$col][$i] -= $mult * $this->matrix[$row][$i];
                        }
                    }
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
            else {
                $reduce = true;

                /* Ищем ненулевой элемент в текущем столбце */
                for ($i = $row + 1; $i < $this->rowsCnt; $i++) {
                    // Меняем местами строку с ненулевым элементом с этой строкой
                    if ($this->matrix[$i][$row]) {
                        $this->swap($row, $i, $rank);
                        $reduce = false;
                        break;
                    }
                }

                // Если мы не нашли ни одной строки с ненулевым элементом в текущем столбце,
                // то все значения в этом столбце равны 0.
                if ($reduce) {
                    // Уменьшаем количество столбцов
                    $rank--;

                    // Копируем последний столбец сюда
                    for ($i = 0; $i < $this->rowsCnt; $i++) {
                        $this->matrix[$i][$row] = $this->matrix[$i][$rank];
                    }
                }

                // Заново обрабатываем текущую строку
                $row--;
            }
        }

        return $rank;
    }
}

///////////////////////////////////////////////////////
// Определяем матрицу
// (*) Проверить решения можно тут: https://matrix.reshish.ru/rankCalculation.php

// rank = 2 (верно)
$matrix = [
    [-1,   1,  -1,  -2,    0],
    [ 2,   2,   6,   0,   -4],
    [ 4,   3,  11,   1,   -7]
];

// rank = 2 (верно)
$matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];

// rank = 2 (верно)
$matrix = [
    [10,   20, 10],
    [-20, -30, 10],
    [30,   50,  0]
];

$rankOp = new MatrixRankOperation();
$rankOp->init($matrix);
$rank = $rankOp->calc();

echo "Ранг матрицы: " . $rank . "\n";
