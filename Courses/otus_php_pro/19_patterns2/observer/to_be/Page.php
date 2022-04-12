<?php


class Page implements Observable
{
    private string $html;
    private News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function addObserver(ObserverInterface $observer)
    {
        // TODO: Implement addObserver() method.
    }

    public function removeObserver(ObserverInterface $observer)
    {
        // TODO: Implement removeObserver() method.
    }

    public function notify()
    {
        // TODO: Implement notify() method.
    }
}