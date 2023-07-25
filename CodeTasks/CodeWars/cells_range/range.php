<?php

/**
 * Get cells addresses
 * @param $range
 * @return array
 */
function getCellAddresses($range)
{
    if (!preg_match('/^([A-Z]+)(\d+):([A-Z]+)(\d+)$/', $range, $matches)) {
        return [];
    }

    list($_, $startCol, $startRow, $endCol, $endRow) = $matches;

    if (ord($startCol) > ord($endCol) || $startRow > $endRow) {
        return [];
    }

    $result = [];

    for ($col = $startCol; $col <= $endCol; $col++) {
        for ($row = $startRow; $row <= $endRow; $row++) {
            $result[] = $col . $row;
        }
    }

    sort($result);

    return $result;

}

var_dump(getCellAddresses("B1:H5"));