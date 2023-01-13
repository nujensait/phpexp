<?php

namespace App\Db\Core;

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
