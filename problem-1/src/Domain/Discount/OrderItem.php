<?php

namespace App\Domain\Discount;

class OrderItem
{
    private int $productId;
    private int $quantity;
    private float $unitPrice;
    private float $total;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->productId = (int)$data['product-id'];
        $this->quantity = (int)$data['quantity'];
        $this->unitPrice = (float)$data['unit-price'];
        $this->total = (float)$data['total'];
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

}
