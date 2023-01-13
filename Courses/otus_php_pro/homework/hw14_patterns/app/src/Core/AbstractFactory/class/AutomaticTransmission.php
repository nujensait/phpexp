<?php

/**
 * Коробка-автомат
 */
namespace src\Patterns\Creational\AbstractFactory;
use src\Patterns\Creational\AbstractFactory\Transmission;

class AutomaticTransmission implements Transmission
{
    protected $transmissionType = "Atomatic";

    public function getTransmissionType(): string
    {
        return $this->transmissionType;
    }
}