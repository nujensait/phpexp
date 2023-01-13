<?php

/**
 * Имплементация бензобака с... бензином!
 */
namespace src\Patterns\Creational\AbstractFactory;
use src\Patterns\Creational\AbstractFactory\FuelTank;

class GasFuelTank implements FuelTank
{
    protected $allowableFuel;
    protected $capacity;

    public function __construct()
    {
        $this->allowableFuel = "Gasoline fuel";
        $this->capacity = "50 litres";
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