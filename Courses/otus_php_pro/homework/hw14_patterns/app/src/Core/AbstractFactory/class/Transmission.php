<?php

/**
 * Интерфейс коробок передач
 */

namespace src\Patterns\Creational\AbstractFactory;

interface Transmission
{
    public function getTransmissionType(): string;
}