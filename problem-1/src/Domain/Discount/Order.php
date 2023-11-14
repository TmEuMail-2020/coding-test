<?php

namespace App\Domain\Discount;

class Order
{
    private int $id;
    private int $customerId;
    private array $items;
    private float $total;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->id = (int)$data['id'];
        $this->customerId = (int)$data['customer-id'];
        $this->items = array_map(function ($item) {
            return new \App\Domain\Discount\OrderItem($item);
        }, $data['items']);
        $this->total = (float)$data['total'];
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

}
