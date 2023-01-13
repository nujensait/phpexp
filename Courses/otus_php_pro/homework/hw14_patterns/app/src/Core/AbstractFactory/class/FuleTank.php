<?php

/**
 * Интерфейс бака для горючего
 */
namespace src\Patterns\Creational\AbstractFactory;

interface FuelTank
{
    public function getAllowableFuel(): string;
    public function getCapacity(): string;
}