<?php

namespace App\Domain\Discount;

class Discount
{
    private float $discountAmount;
    private string $discountReason;

    public function __construct(float $discountAmount, string $discountReason)
    {
        $this->discountAmount = $discountAmount;
        $this->discountReason = $discountReason;
    }

    public function getDiscountAmount(): float
    {
        return $this->discountAmount;
    }

    public function getDiscountReason(): string
    {
        return $this->discountReason;
    }

}
