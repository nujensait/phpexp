<?php

/**
 * Test ExcelRange.php script
 */

use PHPUnit\Framework\TestCase;

require_once("ExcelRange.php");

class RangeTest extends TestCase
{
    public static function basicTestsProvider()
    {
        return [
            'Range A1:A10' => ['A1:A10', [
                'A1', 'A2', 'A3', 'A4', 'A5',
                'A6', 'A7', 'A8', 'A9', 'A10'
            ]],
            'Range A1:Z1' => ['A1:Z1', [
                'A1', 'B1', 'C1', 'D1', 'E1',
                'F1', 'G1', 'H1', 'I1', 'J1',
                'K1', 'L1', 'M1', 'N1', 'O1',
                'P1', 'Q1', 'R1', 'S1', 'T1',
                'U1', 'V1', 'W1', 'X1', 'Y1',
                'Z1'
            ]],
            'Range F12:J17' => ['F12:J17', [
                'F12', 'G12', 'H12', 'I12',
                'J12', 'F13', 'G13', 'H13',
                'I13', 'J13', 'F14', 'G14',
                'H14', 'I14', 'J14', 'F15',
                'G15', 'H15', 'I15', 'J15',
                'F16', 'G16', 'H16', 'I16',
                'J16', 'F17', 'G17', 'H17',
                'I17', 'J17'
            ]],
            'Range B3:D5' => ['B3:D5', [
                'B3', 'C3', 'D3',
                'B4', 'C4', 'D4',
                'B5', 'C5', 'D5'
            ]],
            'Range A1:B2' => ['A1:B2', ['A1', 'B1', 'A2', 'B2']],
            'Range W118:Z124' => ['W118:Z124', [
                'W118', 'X118', 'Y118', 'Z118',
                'W119', 'X119', 'Y119', 'Z119',
                'W120', 'X120', 'Y120', 'Z120',
                'W121', 'X121', 'Y121', 'Z121',
                'W122', 'X122', 'Y122', 'Z122',
                'W123', 'X123', 'Y123', 'Z123',
                'W124', 'X124', 'Y124', 'Z124'
            ]],
            'Range H7:F3 (invalid)' => ['H7:F3', []],
            'Range C2:C2 (invalid)' => ['C2:C2', []],
            'Range AA1:AB2' => ['AA1:AB2', ['AA1', 'AB1', 'AA2', 'AB2']],
        ];
    }

    /**
     * @dataProvider basicTestsProvider
     */
    public function testBasic(string $input, array $expected)
    {
        $this->assertEquals($expected, getCellAddresses($input));
    }
}
