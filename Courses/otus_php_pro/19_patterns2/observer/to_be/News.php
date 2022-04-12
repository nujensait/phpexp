<?php


class News implements Observable
{
    private string $text;
    private array $observers;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
        $this->notify();
    }

    public function addObserver(ObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    public function removeObserver(ObserverInterface $observer)
    {
        foreach ($this->observers as &$search){
            if($search == $observer){
                unset($search);
            }
        }
    }

    public function notify()
    {
        foreach ($this->observers as $observer) {
            /* @var $observer ObserverInterface */
            $observer->handle($this);
        }
    }
}