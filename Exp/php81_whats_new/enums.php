<?php

// Enums (Перечисления)

enum Status {
    case Pending;
    case Active;
    case Archived;
}

// И вот как они будут использоваться:
class Order
{
    private Status $status;

    public function __construct(Status $status = Status::Pending)
    {
        $this->status = $status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status->name;
    }
}

$order = new Order();
echo $order->getStatus();
echo "\n\n";

$order->setStatus(Status::Active);
echo $order->getStatus();
echo "\n\n";
