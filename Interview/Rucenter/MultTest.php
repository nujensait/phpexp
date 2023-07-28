<?php

use PHPUnit\Framework\TestCase;

require_once("Mult.php");

class MultTest extends TestCase
{
    // Тест рандомной функции
    public function testMultiply()
    {
        // Создаем мок
        $mockRandom = $this->createMock(Randomizer::class);

        // Задаем последовательность значений
        $mockRandom->expects($this->exactly(4))
                   ->method('rand')
                   ->willReturnOnConsecutiveCalls(5, 7, 6, 5);

        // Инжектим мок в функцию и Проверяем результат
        $result = multiplyByRandom(10);
        $this->assertEquals(50, $result);

        $result = multiplyByRandom(10);
        $this->assertEquals(70, $result);

        $result = multiplyByRandom(20);
        $this->assertEquals(120, $result);

        $result = multiplyByRandom(0);
        $this->assertEquals(0, $result);
    }
}

