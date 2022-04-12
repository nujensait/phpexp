<?php


class Page
{
    private string $html;
    private News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }
}