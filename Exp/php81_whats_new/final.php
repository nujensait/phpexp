<?php

// Окончательные константы класса
// Теперь константы класса можно объявить как окончательные (final),
// чтобы их нельзя было переопределить в дочерних классах.

class Foo
{
    final public const XX = "foo";
}

class Bar extends Foo
{
    public const XX = "bar"; // Fatal error: Bar::XX cannot override final constant Foo::XX
}

$bar = new Bar();
