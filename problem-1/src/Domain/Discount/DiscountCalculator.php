<?php

namespace App\Domain\Discount;

class DiscountCalculator
{
    private \App\Domain\Discount\Order $order;
    private \App\Domain\Discount\IDiscountStrategy $discountStrategy;

    public function __construct(
        \App\Domain\Discount\Order $order,
        \App\Domain\Discount\IDiscountStrategy $discountStrategy
    ) {
        $this->order = $order;
        $this->discountStrategy = $discountStrategy;
    }

    public function calculateDiscountAndReason(): \App\Domain\Discount\Discount
    {
        return $this->discountStrategy->calculateDiscountAndReason($this->order);
    }
}
