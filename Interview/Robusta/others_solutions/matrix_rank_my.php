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
    public function init(array $matrix): void
    {
        $this->matrix = $matrix;
        // Получаем количество строк и столбцов матрицы
        $this->rowsCnt = count($this->matrix);
        $this->columnsCnt = count($this->matrix[0]);
    }

    /**
     * Function for exchanging two rows of a matrix
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
     *
     * Рангом системы строк (столбцов) матрицы A с M строками и N столбцами называется максимальное число линейно независимых строк (столбцов).
     * Несколько строк (столбцов) называются линейно независимыми, если ни одна из них не выражается линейно через другие.
     * Ранг системы строк всегда равен рангу системы столбцов, и это число называется рангом матрицы.
     *
     * @return float
     */
    public function calc(): float
    {
        /*
        $rank = $this->columnsCnt;
        foreach ($this->matrix as $row) {
            $rowUniqueCount = count(array_unique($row));
            if ($rowUniqueCount < $this->columnsCnt) {
                $rank--;
            }
        }
        return $rank;
        */

        $rank = $this->columnsCnt;

        for ($row = 0; $row < $rank; $row++) {
            // Before we visit current row 'row', we make
            // sure that matrix[row][0],....matrix[row][row-1]
            // are 0.

            // Diagonal element is not zero
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

            // Diagonal element is already zero. Two cases
            // arise:
            // 1) If there is a row below it with non-zero
            // entry, then swap this row with that row
            // and process that row
            // 2) If all elements in current column below
            // matrix[r][row] are 0, then remove this column
            // by swapping it with last column and
            // reducing number of columns by 1.
            else {
                $reduce = true;

                /* Find the non-zero element in current
                    column */
                for ($i = $row + 1; $i < $this->rowsCnt; $i++) {
                    // Swap the row with non-zero element
                    // with this row.
                    if ($this->matrix[$i][$row]) {
                        $this->swap($row, $i, $rank);
                        $reduce = false;
                        break;
                    }
                }

                // If we did not find any row with non-zero
                // element in current column, then all
                // values in this column are 0.
                if ($reduce) {
                    // Reduce number of columns
                    $rank--;

                    // Copy the last column here
                    for ($i = 0; $i < $this->rowsCnt; $i++) {
                        $this->matrix[$i][$row] = $this->matrix[$i][$rank];
                    }
                }

                // Process this row again
                $row--;
            }
        }

        return $rank;
    }
}

///////////////////////////////////////////////////////

// Определяем матрицу
// rank = 2
// (программа пишет: 3, не верно)
/*
$matrix = array(
    array(-1, 1, -1, -2, 0),
    array(2, 2, 6, 0, 0, -4),
    array(4, 3, 11, 1, -7)
);
*/


// rank = 3
$matrix = array(
    array(1, 2, 3),
    array(4, 5, 6),
    array(7, 8, 9)
);

$rankOp = new MatrixRankOperation();
$rankOp->init($matrix);
$rank = $rankOp->calc();

echo "Ранг матрицы: " . $rank;
