<?php

/**
 * Имплементация бензинового мотора
 */

namespace src\Patterns\Creational\AbstractFactory;
use src\Patterns\Creational\AbstractFactory\Engine;

class GasEngine implements Engine
{
    protected $fuelType;
    protected $maxRPM;

    public function __construct()
    {
        $this->fuelType = "Gasoline";
        $this->maxRPM = "9000";
    }

    public function getFuelType(): string
    {
        return $this->fuelType;
    }

    public function getMaxRPM(): string
    {
        return $this->maxRPM;
    }
}