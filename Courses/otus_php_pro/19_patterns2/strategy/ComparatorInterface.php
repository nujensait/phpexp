<?php


interface ComparatorInterface
{
    public function compare($a, $b): int;
}