<?php

/**
 * @source ChatGpt 4.5
 */

/**
    В программе создается класс Matrix с двумя методами:
    - rank(вычисление ранга матрицы)
    - gaussianElimination (реализация метода Гаусса).

    Метод rank вызывает gaussianElimination для приведения матрицы к ступенчатому виду,
    а затем подсчитывает количество ненулевых строк для определения ранга.

    Обход элементов матрицы и строки осуществляется с помощью функций array_map и array_reduce.

    Метод gaussianElimination использует алгоритм Гаусса для приведения матрицы к ступенчатому виду.
    Этот метод использует три основные операции над строками матрицы: перестановку строк,
    масштабирование строки и добавление масштабированной строки к другой строке.

    Эти операции реализуются с помощью методов swapRows, scaleRow и addScaledRow соответственно.

    В конце программы создается экземпляр класса Matrix, передается матрица,
    а затем вызывается метод rank для вычисления ранга этой матрицы.
 */
class Matrix
{
    private $matrix;

    public function __construct($matrix) {
        $this->matrix = $matrix;
    }

    public function rank() {
        $this->matrix = $this->gaussianElimination($this->matrix);
        return array_reduce($this->matrix, function ($rank, $row) {
            return $rank + (array_reduce($row, function ($nonZero, $cell) {
                    return $nonZero || abs($cell) > 0.00001;
                }, false) ? 1 : 0);
        }, 0);
    }

    private function gaussianElimination($matrix) {
        $rowCount = count($matrix);
        $columnCount = count($matrix[0]);

        $row = 0;
        foreach (range(0, $columnCount - 1) as $column) {
            $pivotRow = null;
            foreach (range($row, $rowCount - 1) as $r) {
                if (abs($matrix[$r][$column]) > 0.00001) {
                    $pivotRow = $r;
                    break;
                }
            }
            if ($pivotRow === null) {
                continue;
            }

            $matrix = $this->swapRows($matrix, $row, $pivotRow);
            $matrix = $this->scaleRow($matrix, $row, 1 / $matrix[$row][$column]);

            foreach (range(0, $rowCount - 1) as $r) {
                if ($r !== $row) {
                    $matrix = $this->addScaledRow($matrix, $r, $row, -$matrix[$r][$column]);
                }
            }

            $row++;
        }

        return $matrix;
    }

    private function swapRows($matrix, $row1, $row2) {
        $temp = $matrix[$row1];
        $matrix[$row1] = $matrix[$row2];
        $matrix[$row2] = $temp;
        return $matrix;
    }

    private function scaleRow($matrix, $row, $scale) {
        return array_map(function ($r) use ($row, $scale) {
            return $r === $row ? array_map(function ($cell) use ($scale) {
                return $cell * $scale;
            }, $r) : $r;
        }, $matrix);
    }

    private function addScaledRow($matrix, $row1, $row2, $scale) {
        return array_map(function ($r) use ($row1, $row2, $scale) {
            return $r === $row1 ? array_map(function ($cell1, $cell2) use ($scale) {
                return $cell1 + $cell2 * $scale;
            }, $r, $matrix[$row2]) : $r;
        }, $matrix);
    }
}

// @source https://www.geeksforgeeks.org/program-for-rank-of-matrix/
// rank = 2 (пишет 3, не верно)
$matrix = [
    [10,   20,   10],
    [20,   40,   20],
    [30,   50,   0],
];

// https://zaochnik.com/spravochnik/matematika/matritsy/rang-matritsy/
// rank = 2 (ошибка в вычислениях, видать, только для квадратных матриц)
$matrix = [
    [-1,   1,  -1,  -2,    0],
    [ 2,   2,   6,   0,   -4],
    [ 4,   3,  11,   1,   -7]
];

// rank = 2 (пишет 3, не верно)
$matrix = [
    [10,   20, 10],
    [-20, -30, 10],
    [30,   50,  0]
];

// rank = 3 (пример, сгенерированный нейронкой)
// (ранг равен 2 на самом деле, проверял тут: https://matrix.reshish.ru/rankCalculation.php)
$matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
];

$matrixObj = new Matrix($matrix);
echo "Rank: " . $matrixObj->rank() . "\n";
