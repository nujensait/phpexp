<?php

/**
 * Excel cells range
 * @see https://www.codewars.com/kata/62c376ce1019024820580309/train/php
 * @see Readme.md
 *
 * @fixme: make chg to use cells addr like AA1 ... ZZ3
 */

class ExcelRange
{
    const ORD_START = 64;      // 65 is 'A' position in alphabet
    const LETTERS_COUNT = 26;      // 26 is eng alphabet letters count

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

        print "Cells range: ";
        var_dump($range);

        if ($range == null) {
            return null;
        }

        list($startCol, $startRow, $endCol, $endRow) = $range;

        $result = [];

        for ($row = $startRow; $row <= $endRow; $row++) {
            for ($col = $startCol; $col <= $endCol; $col++) {
                $letter = $this->calcColLetter($col);
                $result[$row - 1][] = $letter . $row;
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

        $startCol = $this->calcColNum($startCol);
        $endCol = $this->calcColNum($endCol);

        if (ord($startCol) > ord($endCol) || $startRow > $endRow) {
            return [];
        }

        return [(string)$startCol, (int)$startRow, (string)$endCol, (int)$endRow];
    }

    /**
     * Calc excel column number by it's letter: B ~ 2, AA ~ 27, etc.
     * @param string $letter
     * @return int
     */
    public function calcColNum(string $letter): int
    {
        $sum = 0;
        $len = strlen($letter);

        for($i = 0; $i < $len; $i++) {
            $num = (ord($letter[$i]) - self::ORD_START) * pow(self::LETTERS_COUNT, $len - $i - 1);
            $sum += $num;
        }

        return $sum;
    }

    /**
     * Opposite to calcColNum: calc column letter by it's number
     * @param int $num
     * @return string
     */
    public function calcColLetter(int $num): string
    {
        $col = '';

        while($num > 0) {
            $rem = ($num - 1) % self::LETTERS_COUNT;
            $col = chr(self::ORD_START + 1 + $rem) . $col;
            $num = intdiv($num - 1, self::LETTERS_COUNT);
        }

        return $col;
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
function getCellAddresses(string $range): ?array
{
    $sheet = new ExcelRange();
    $cells = $sheet->getCellAddresses($range);
    //$sheet->printCells($cells);
    return $cells;
}
