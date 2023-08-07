<?php

class Order
{
    public readonly bool $status;

    public function __construct(bool $status)
    {
        $this->status = $status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;        // Fatal error: Uncaught Error: Cannot modify readonly property Order::$status
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}

$order = new Order(1);
var_dump($order->getStatus());

$order->setStatus(0);
var_dump($order->getStatus());