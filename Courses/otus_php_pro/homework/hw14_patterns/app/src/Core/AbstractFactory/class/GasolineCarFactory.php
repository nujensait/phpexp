<?php

/**
 * Фабрика по производству компонентов для
 * автомобиля на бензине
 */

namespace src\Patterns\Creational\AbstractFactory;
use src\Patterns\Creational\AbstractFactory\CarFactory;
use src\Patterns\Creational\AbstractFactory\GasFuelTank;
use src\Patterns\Creational\AbstractFactory\GasEngine;
use src\Patterns\Creational\AbstractFactory\AutomaticTransmission;

class GasolineCarFactory implements CarFactory
{
    public function createFuelTank(): FuelTank
    {
        return new GasFuelTank();
    }

    public function createEngine(): Engine
    {
        return new GasEngine();
    }

    public function createTransmission(): Transmission
    {
        return new AutomaticTransmission();
    }
}
