<?php


class NewsCollection
{
    private array $news;
    private ComparatorInterface $comparator;

    public function __construct(array $news = []) {
        $this->news = $news;
    }

    public function sort()
    {
        if (!$this->comparator) {
            throw new \Exception('Comparator is not set');
        }

        uasort($this->news, [$this->comparator, 'compare']);

        return $this->news;
    }

    public function setComparator(ComparatorInterface $comparator): void
    {
        $this->comparator = $comparator;
    }

}