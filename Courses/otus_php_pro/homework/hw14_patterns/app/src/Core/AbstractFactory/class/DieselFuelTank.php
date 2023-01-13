<?php

/**
 * Имплементация дизельного бака для горючего
 */
namespace src\Patterns\Creational\AbstractFactory;
use src\Patterns\Creational\AbstractFactory\FuelTank;

class DieselFuelTank implements FuelTank
{
    protected $allowableFuel;
    protected $capacity;

    public function __construct()
    {
        $this->allowableFuel = "Diesel fuel";
        $this->capacity = "70 litres";
    }

    public function getAllowableFuel(): string
    {
        return $this->allowableFuel;
    }

    public function getCapacity(): string
    {
        return $this->capacity;
    }
}
