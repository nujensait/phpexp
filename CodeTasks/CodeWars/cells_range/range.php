<?php

/**
 * Excel cells range
 * @see https://www.codewars.com/kata/62c376ce1019024820580309/train/php
 * @see Readme.md
 *
 * @fixme: make chg to use cells addr like AA1 ... ZZ3
 */

class ExcelSheet
{
    public function getCellAddresses(string $range): ?array
    {
        $matrix = $this->getCellAddressesMatrix($range);
        if($matrix == null) {
            return null;
        }

        $this->printCellsMatrix($matrix);

        $res = [];
        foreach($matrix as $row) {
            foreach($row as $cell) {
                $res[] = $cell;
            }
        }

        return $res;
    }

    /**
     * Get cells addresses
     * @param $range
     * @return array
     */
    public function getCellAddressesMatrix(string $range): ?array
    {
        $range = $this->getRange($range);
        var_dump($range);
        if ($range == null) {
            return null;
        }
        list($startCol, $startRow, $endCol, $endRow) = $range;

        $result = [];

        for ($row = $startRow; $row <= $endRow; $row++) {
            for ($col = $startCol; $col <= $endCol; $col++) {
                $result[$row - 1][] = $col . $row;
            }
        }

        //var_dump($result); die();
        //sort($result);

        return $result;
    }

    /**
     * Get cells range as array
     * @param string $range
     * @return array
     */
    public function getRange(string $range): array
    {
        if (!preg_match('/^([A-Z]+)(\d+):([A-Z]+)(\d+)$/', $range, $matches)) {
            return [];
        }

        list($_, $startCol, $startRow, $endCol, $endRow) = $matches;

        if (ord($startCol) > ord($endCol) || $startRow > $endRow) {
            return [];
        }

        return [(string)$startCol, (int)$startRow, (string)$endCol, (int)$endRow];
    }

    /**
     * @param $arr
     * @return void
     */
    public function printCellsMatrix(array $arr): void
    {
        for ($i = 0; $i < count($arr); $i++) {
            for ($j = 0; $j < count($arr[$i]); $j++) {
                print $arr[$i][$j] . " ";
            }
            echo "\n";
        }
    }
}

/**
 * @param string $range
 * @return array
 */
function getCellAddresses(string $range): array
{
    $sheet = new ExcelSheet();
    $cells = $sheet->getCellAddresses($range);
    //$sheet->printCells($cells);
    return $cells;
}

//$cells = getCellAddresses("B1:H5");
//var_dump($cells);

$cells = getCellAddresses("A1:A12");
var_dump($cells);
