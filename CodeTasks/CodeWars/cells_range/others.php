<?php

// Others solutuion (not mine)

function getCellAddresses(string $range): array {
    try {
        $range = new Range($range);
    } catch(\Exception $e) {
        return [];
    }
    $result = [];
    for($row = $range->start->getRow(); $row <= $range->end->getRow(); $row++) {
        for($col = ord($range->start->getCol()); $col <= ord($range->end->getCol()); $col++) {
            $result[] = chr($col).$row;
        }
    }
    return $result;
}

class Range
{
    public Cell $start;
    public Cell $end;
    public function __construct(string $range)
    {
        $splitRange = explode(":", $range);
        $this->start = new Cell($splitRange[0]);
        $this->end = new Cell($splitRange[1]);
        if(ord($this->start->getCol()) > ord($this->end->getCol()) || $this->start == $this->end) {
            throw new \Exception("Invalid range");
        }
    }
}

class Cell
{
    public function __construct(
        public string $address
    )
    {
        //
    }

    public function getCol()
    {
        return $this->address[0];
    }

    public function getRow()
    {
        return (int) substr($this->address, 1);
    }

    public function __toString() {
        return $this->address;
    }
}