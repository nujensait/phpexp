<?php

/**
 * Тестирование операции по вычислению ранга матрицы
 *
 * Пример использования:
 * phpunit MatrixRankOperationTest.php
 */
class MatrixRankOperationTest extends PHPUnit_Framework_TestCase
{
    private $op;

    private $testCases = [
        1 => [
            [
                [10,   20,  10],
                [-20, -30,  10],
                [30,   50,   0]
            ],
            2
        ],
        2 => [
            [
                [1, 2, 3],
                [4, 5, 6],
                [7, 8, 9]
            ],
            2
        ],
        3 => [
            [
                [-1, 1, -1, -2,  0],
                [2,  2,  6,  0, -4],
                [4,  3, 11,  1, -7]
            ],
            2
        ],
        4 => [
            [
                [ 10.3,   20.6,  10.56],
                [-20.4,  -30.7,   10.4],
                [ 30.5,   50.8,      0]
            ],
            3
        ]
    ];

    /**
     * Init test
     * @return void
     */
    protected function setUp()
    {
        $this->op = new MatrixRankOperation();
    }

    /**
     * Finish test
     * @return void
     */
    protected function tearDown()
    {
        $this->op = NULL;
    }

    /**
     * Test operation
     * @return void
     */
    public function testOp()
    {
        foreach($this->testCases as $testData) {
            $matrix = $testData[0];
            $this->op->init($matrix);
            $result = $this->op->calc();
            $this->assertEquals($testData[1], $result);
        }
    }
}