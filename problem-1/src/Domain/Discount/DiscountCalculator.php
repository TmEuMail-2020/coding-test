<?php

namespace App\Domain\Discount;

class DiscountCalculator
{
    private Order $order;
    private IDiscountStrategy $discountStrategy;

    public function __construct(
        Order $order,
        IDiscountStrategy $discountStrategy
    ) {
        $this->order = $order;
        $this->discountStrategy = $discountStrategy;
    }

    public function calculateDiscountAndReason(): Discount
    {
        return $this->discountStrategy->calculateDiscountAndReason($this->order);
    }
}
