<?php

use PHPUnit\Framework\TestCase;

require_once("Randomizer.php");

class MultTest extends TestCase
{
    // Тест рандомной функции
    public function testMultiply()
    {
        // Создаем мок
        $randMock = $this->createStub(Randomizer::class);

        // Задаем последовательность значений
        $randMock->expects($this->exactly(4))
                 ->method('getRand')
                 ->willReturnOnConsecutiveCalls(2, 7, 6, 5);

        // Не достаточно переопределить ф-ю getRand,
        // ф-ю ее вызывающую также обновить нужно: иначе она вызовет оригинальную getRand()
        $randMock->expects($this->exactly(4))
            ->method('multiplyByRandom')
            ->willReturnCallback(function (&$x) use ($randMock) {
                return $x * $randMock->getRand();
            });

        // Инжектим мок в функцию и Проверяем результат
        $result = $randMock->multiplyByRandom(3);
        $this->assertEquals(6, $result);        // 2 * 3 = 6

        $result = $randMock->multiplyByRandom(10);
        $this->assertEquals(70, $result);       // 10 * 7 = 70

        $result = $randMock->multiplyByRandom(20);
        $this->assertEquals(120, $result);      // 20 * 6 = 120

        $result = $randMock->multiplyByRandom(0);
        $this->assertEquals(0, $result);        // 0 * 5 = 0
    }
}

