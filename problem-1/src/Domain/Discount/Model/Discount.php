<?php

namespace App\Domain\Discount\Model;

class Discount implements \JsonSerializable
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

    public function jsonSerialize(): mixed
    {
       return [
           // TODO: feel not right to do rounding here
           'discountAmount' => round($this->discountAmount, 2),
           'discountReason' => $this->discountReason,
       ];
    }
}
