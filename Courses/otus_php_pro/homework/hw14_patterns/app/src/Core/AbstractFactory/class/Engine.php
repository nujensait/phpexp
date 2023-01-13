<?php
/**
 * Интерфейс двигателя: содержит
 * информацию об используемом топливе
 * и максимальном количестве оборотов двигателя
 */
namespace src\Patterns\Creational\AbstractFactory;

interface Engine
{
    public function getFuelType(): string;
    public function getMaxRPM(): string;
}