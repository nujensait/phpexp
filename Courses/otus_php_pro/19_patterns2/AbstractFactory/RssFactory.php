<?php


class RssFactory extends AbstractFactory
{

    public function createArticle(string $content): Article
    {
        return new RssArticle($content);
    }

    public function createRenderer(): void
    {
        // TODO: Implement createRenderer() method.
        $renderer = new RssRenderer();
    }
}