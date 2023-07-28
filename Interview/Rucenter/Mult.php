<?php

/**
 * Класс со случайным числом
 */
class Randomizer
{
    /**
     * @return int
     */
    public function rand(): int
    {
        return mt_rand(1, 10);
    }
}

/** Тестируемая функция
 * @param int $num
 * @return int
 */
function multiplyByRandom(int $num): int {
    $random = new Randomizer();
    return $num * $random->rand();
}
