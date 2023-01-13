<?php

/**
 * Creational Patterns: Abstract Factory
 * DieselCarFactory class
 *
 * Фабрика по производству дизельных компонентов
 * для машины
 */

namespace src\Patterns\Creational\AbstractFactory;
use src\Patterns\Creational\AbstractFactory\CarFactory;
use src\Patterns\Creational\AbstractFactory\DieselFuelTank;
use src\Patterns\Creational\AbstractFactory\DieselEngine;
use src\Patterns\Creational\AbstractFactory\MechanicalTransmission;

class DieselCarFactory implements CarFactory
{
    public function createFuelTank(): FuelTank
    {
        return new DieselFuelTank();
    }

    public function createEngine(): Engine
    {
        return new DieselEngine();
    }

    public function createTransmission(): Transmission
    {
        return new MechanicalTransmission();
    }
}
