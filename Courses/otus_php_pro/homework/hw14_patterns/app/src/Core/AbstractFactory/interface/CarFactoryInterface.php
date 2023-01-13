<?php

/**
 * Интерфейс нашей обстратной фабрики
 */
namespace src\Patterns\Creational\AbstractFactory;
use src\Patterns\Creational\AbstractFactory\FuelTank;
use src\Patterns\Creational\AbstractFactory\Engine;
use src\Patterns\Creational\AbstractFactory\Transmission;

interface CarFactory
{
    public function createFuelTank(): FuelTank;
    public function createEngine(): Engine;
    public function createTransmission(): Transmission;
}
