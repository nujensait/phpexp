<?php


abstract class AbstractFactory
{
    abstract public function createArticle(string $content): Article;
    abstract public function createRenderer(): void;
}