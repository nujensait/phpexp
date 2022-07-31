<?php
declare(strict_types=1);

namespace App;

use Exception;

class MushroomCollector
{
    private $name;
    private $count;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->count = 0;
    }

    public function collect(int $mushroomCount): void
    {
        $this->count += $mushroomCount;
    }

    public function goHome(): string
    {
        $result = $this->prepareResultString();
        $this->count = 0;
        return $result;
    }

    private function prepareResultString(): string
    {
        $result = "{$this->name} принёс домой {$this->count}";
        if ($this->count > 1000) {
            throw new Exception("Слишком много грибов, {$this->name} надорвался");
        }
/*        if ($this->count % 100 / 10 === 1) {
            return "$result грибов";
        }*/
        switch($this->count % 10) {
            case 1:
                return "$result гриб";
            case 2:
            case 3:
            case 4:
                return "$result гриба";
        }
        return "$result грибов";
    }
}