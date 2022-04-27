<?php


class HtmlFactory extends AbstractFactory
{
    public function createArticle(string $content): Article
    {
        return new HtmlArticle($content);
    }

    public function createRenderer(): void
    {
        // TODO: Implement createRenderer() method.
        $render = new HtmlRenderer();
    }
}