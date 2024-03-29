<?php

// Файберы — также известные как «зеленые потоки» - это низкоуровневый механизм управления параллелизмом.
// Это примитивы для реализации облегчённой невытесняющей конкурентности.
// Они являются средством создания блоков кода, которые можно приостанавливать и возобновлять,
// как генераторы, но из любой точки стека. Файберы сами по себе не предоставляют возможностей асинхронного выполнения задач,
// всё равно должен быть цикл обработки событий. Однако они позволяют блокирующим и неблокирующим реализациям использовать один и тот же API.
// (*) Вероятно, вы не будете использовать их непосредственно в своих приложениях,
// но такие фреймворки, как Amphp и ReactPHP, будут широко их использовать.
// @see PHP 8.1: Fibers (Файберы) https://sergeymukhin.com/blog/php-81-fibers

$fiber = new Fiber(function (): void {
    $push = Fiber::suspend('вытолкнули');
    echo "Значение для resume: ", $push, "\n";
});

$put = $fiber->start();

echo "Значение для suspend: ", $put, "\n";
$fiber->resume('втолкнули');

