<?php

/**
 * Test ExcelRange.php script
 */

use PHPUnit\Framework\TestCase;

require_once("ExcelRange.php");

class FuncsTest extends TestCase
{
    /**
     * @return array
     */
    public static function calcColLetterProvider(): array
    {
        return [
            "1 ~ A" => [1, "A"],
            "26 ~ Z" => [26, "Z"],
            "27 ~ AB" => [27, "AA"],
            "29 ~ AC" => [29, "AC"],
            "728 ~ AAZ" => [728, "AAZ"],
        ];
    }

    /**
     * @return array
     */
    public static function calcColNumProvider(): array
    {
        return [
            "A ~ 1" => ["A", 1],
            "Z ~ 26" => ["Z", 26],
            "AA ~ 27" => ["AA", 27],
            "AC ~ 29" => ["AC", 29],
            "AAZ ~ 728" => ["AAZ", 728],
        ];
    }

    /**
     * @dataProvider calcColLetterProvider
     */
    public function testCalcColLetter(int $input, string $expected)
    {
        $obj = new ExcelRange();

        $this->assertEquals($expected, $obj->calcColLetter($input));
    }

    /**
     * @dataProvider calcColNumProvider
     */
    public function testCalcColNum(string $input, int $expected)
    {
        $obj = new ExcelRange();

        $this->assertEquals($expected, $obj->calcColNum($input));
    }

    /**
     * Trivial test
     * @return void
     */
    public function testStart()
    {
        $this->assertEquals(true, true);
    }
}
