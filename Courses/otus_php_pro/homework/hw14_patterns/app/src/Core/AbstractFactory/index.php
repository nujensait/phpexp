<?php

/**
 * App running script
 */

$carAssembler = new CarAssembler(new GasolineCarFactory());

$carAssembler->assembleCar();
$carAssembler->describeCar();

$carAssembler->resetCar();
$carAssembler->changeFactory(new DieselCarFactory());

$carAssembler->assembleCar();
$carAssembler->describeCar();