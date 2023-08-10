<?php


abstract class Article
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }
}