<?php

namespace App\Db\Core;

use src\Patterns\Creational\AbstractFactory\CarAssembler;
use src\Patterns\Creational\AbstractFactory\GasolineCarFactory;
use src\Patterns\Creational\AbstractFactory\DieselCarFactory;

class App
{
    /**
     * @throws \Exception
     */
    public function __construct()
    {
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $carAssembler = new CarAssembler(new GasolineCarFactory());

        $carAssembler->assembleCar();
        $carAssembler->describeCar();

        $carAssembler->resetCar();
        $carAssembler->changeFactory(new DieselCarFactory());

        $carAssembler->assembleCar();
        $carAssembler->describeCar();
    }
}
