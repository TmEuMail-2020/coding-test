<?php

namespace App\Domain\Discount;

class Discount
{
    private float $totalAfterDiscount;
    private string $discountReason;

    public function __construct(float $totalAfterDiscount, string $discountReason)
    {
        $this->totalAfterDiscount = $totalAfterDiscount;
        $this->discountReason = $discountReason;
    }

    public function getTotalAfterDiscount(): float
    {
        return $this->totalAfterDiscount;
    }

}
