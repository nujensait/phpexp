<?php

/**
 * Класс со случайным числом
 */
class Randomizer
{
    /**
     * @return int
     */
    public function getRand(): int
    {
        return mt_rand(1, 10);
    }

    /** Тестируемая функция
     * @param int $num
     * @return int
     */
    public function multiplyByRandom(int $num): int
    {
        return $num * $this->getRand();
    }
}

