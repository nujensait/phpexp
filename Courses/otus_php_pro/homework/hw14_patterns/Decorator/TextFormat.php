<?php

/**
 * Базовый класс Декоратора не содержит реальной логики фильтрации или
 * форматирования. Его основная цель – реализовать базовую инфраструктуру
 * декорирования: поле для хранения обёрнутого компонента или другого декоратора
 * и базовый метод форматирования, который делегирует работу обёрнутому объекту.
 * Реальная работа по форматированию выполняется подклассами.
 */
class TextFormat implements InputFormat
{
    /**
     * @var InputFormat
     */
    protected $inputFormat;

    public function __construct(InputFormat $inputFormat)
    {
        $this->inputFormat = $inputFormat;
    }

    /**
     * Декоратор делегирует всю работу обёрнутому компоненту.
     */
    public function formatText(string $text): string
    {
        return $this->inputFormat->formatText($text);
    }
}
