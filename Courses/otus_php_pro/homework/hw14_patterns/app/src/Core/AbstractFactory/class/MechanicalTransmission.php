<?php

/**
 * Имплементация мехнической коробки передач
 */
namespace src\Patterns\Creational\AbstractFactory;
use src\Patterns\Creational\AbstractFactory\Transmission;

class MechanicalTransmission implements Transmission
{
    protected $transmissionType = "Mechanic";

    public function getTransmissionType(): string
    {
        return $this->transmissionType;
    }
}
