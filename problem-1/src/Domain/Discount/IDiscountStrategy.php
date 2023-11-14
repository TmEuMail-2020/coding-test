<?php

namespace App\Domain\Discount;

interface IDiscountStrategy
{
    public function calculateDiscountAndReason(Order $order): Discount;
}
