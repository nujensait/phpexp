<?php

/**
 * Имплементация интерфейса Engine для
 * дизельного мотора
 */

namespace src\Patterns\Creational\AbstractFactory;
use src\Patterns\Creational\AbstractFactory\Engine;

class DieselEngine implements Engine
{
    protected $fuelType;
    protected $maxRPM;

    public function __construct()
    {
        $this->fuelType = "Diesel";
        $this->maxRPM = "4000";
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
