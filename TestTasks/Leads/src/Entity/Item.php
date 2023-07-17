<?php

namespace App\Entity;

class Item
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $orderId;

    /** @var string */
    protected $productId;

    /** @var string */
    protected $price;

    /** @var string */
    protected $quantity;

    /**
     * @param string $orderId
     * @param string $productId
     * @param string $price
     * @param string $quantity
     */
    public function __construct($orderId, $productId, $price, $quantity)
    {
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     * @return Item
     */
    public function setProductId(int $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }
}